<?php
namespace Controllers;

use Models\Pet as Pet;
use DAO\OwnerDAO as OwnerDAO;
use DAO\PetDAO as PetDAO;


class PetController {
public $petDAO;


    public function __construct()
    {
        $this->petDAO = new petDAO();
    }
    
 public function ShowPerfilView($message = ""){
        require_once(VIEWS_PATH . "validate-session.php");
        $petList = $this->petDAO->GetById_User($_SESSION["loggedUser"]->GetId());
        require_once(VIEWS_PATH . "perfil-petlist.php");
    }
    public function ShowUploadVideo($PETID) {
        require_once(VIEWS_PATH . "validate-session.php");
        $PETID = $PETID;
        require_once(VIEWS_PATH . "video-files.php");
    }

    public function ShowUploadPetVaccination($PETID) {
        require_once(VIEWS_PATH . "validate-session.php");
        $pet = $this->petDAO->GetById($PETID);;
        require_once(VIEWS_PATH . "vaccination-files.php");
    }
    public function ShowUploadPetPicture($PETID) {
        require_once(VIEWS_PATH . "validate-session.php");
        $PETID = $PETID;
        require_once(VIEWS_PATH . "picture-files.php");
    }

    public function ShowAddView() {
        require_once(VIEWS_PATH . "validate-session.php");
    
        require_once(VIEWS_PATH . "add-choice.php");
    }

    public function ShowListView() {
        require_once(VIEWS_PATH . "validate-session.php");
        $petList = $this->petDAO->GetAll();
        require_once(VIEWS_PATH . "perfil-petlist.php");
    }

    public function ShowModifyView($id_Pet) {
        require_once(VIEWS_PATH . "validate-session.php");
        $pet = $this->petDAO->GetById($id_Pet);
        require_once(VIEWS_PATH . "modify-pet.php");
    }

    public function UploadPicture($MAX_FILE_SIZE,$IDPET){
        require_once(VIEWS_PATH . "validate-session.php");
         if( isset($_FILES['pic'])){
           $fileType = $_FILES['pic']['type'];
        if(($fileType=="image/gif")||($fileType =="image/jpeg")||
         ($fileType=="image/jpg")|| ($fileType== "image/png")){
    if( $_FILES['pic']['error'] == 0){
        $dir = IMG_PATH;
       $filename = "IMG".$_SESSION["loggedUser"]->GetUserName(). $IDPET . ".jpg";
        $newFile = $dir . $filename;
        if( move_uploaded_file($_FILES['pic']['tmp_name'], $newFile) ){
            $this->petDAO->uploadPicture($filename,$IDPET);
            $this->ShowPerfilView($_FILES['pic']['name'] . ' was uploaded and saved as '. $filename . '</br>');
        }else{
           $this->ShowPerfilView("failed to move file error");
        }   
    }else{
      $this->ShowPerfilView("failed to move file error");
    }
  }else{
    $this->ShowPerfilView("Error formato no aceptado. Formatos aceptados:jpg,jpeg,gif,png");
  }
  }else{
    $this->ShowPerfilView("failed to move file error");
  }
  }

        public function Remove($ID)
        {
            $this->petDAO->Remove($ID);

            $this->ShowPerfilView();
        }

        public function UploadVideo($MAX_FILE_SIZE,$IDPET){
            require_once(VIEWS_PATH . "validate-session.php");
         if( isset($_FILES['video'])){
            $fileType = $_FILES['video']['type'];
            var_dump($fileType);
            if($fileType =="video/mp4"){
         if( $_FILES['video']['error'] == 0){
            $dir = IMG_PATH;
            $filename = "video".$_SESSION["loggedUser"]->GetUserName(). $IDPET . ".mp4";
            $newFile = $dir . $filename;
            if( move_uploaded_file($_FILES['video']['tmp_name'], $newFile) ){
                $this->petDAO->UploadVideo($filename,$IDPET);
                $this->ShowPerfilView($_FILES['video']['name'] . ' was uploaded and saved as '. $filename . '</br>');
            }else{
               $this->ShowPerfilView("failed to move file error");
            }
        }else{
            $this->ShowPerfilView("error to user - file error");
        }
    }else{
        $this->ShowPerfilView("Formato no disponible, solo se aceptan MP4");
    }
    }else{
        $this->ShowPerfilView("failed to move file error");
    }    
        }

}
