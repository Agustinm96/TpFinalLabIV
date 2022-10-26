<?php
namespace Controllers;



use Models\Pet as Pet;
use DAO\DogDAO as DogDAO;
use DAO\PetDAO as PetDAO;

class PetController {
public $petDAO;

    public function __construct()
    {
        $this->petDAO = new petDAO();
    }
    
 public function ShowPerfilView($message = ""){
        require_once(VIEWS_PATH . "validate-session.php");
        $petList = $this->petDAO->GetByUserName($_SESSION["loggedUser"]->GetUserName());
        require_once(VIEWS_PATH . "perfil-petlist.php");
    }
    public function ShowUploadVideo($PETID) {
        require_once(VIEWS_PATH . "validate-session.php");
        $PETID = $PETID;
        require_once(VIEWS_PATH . "video-files.php");
    }

    public function ShowUploadPetVaccination($PETID) {
        require_once(VIEWS_PATH . "validate-session.php");
        $PETID = $PETID;
        require_once(VIEWS_PATH . "vaccination-files.php");
    }
    public function ShowUploadPetPicture($PETID) {
        require_once(VIEWS_PATH . "validate-session.php");
        $PETID = $PETID;
        require_once(VIEWS_PATH . "picture-files.php");
    }

    public function ShowAddView() {
        require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "add-dog.php");
    }

    public function ShowListView() {
        require_once(VIEWS_PATH . "validate-session.php");
        $petList = $this->petDAO->GetAll();
        require_once(VIEWS_PATH . "perfil-petlist.php");
    }

    public function UploadPicture($MAX_FILE_SIZE,$IDPET){
        require_once(VIEWS_PATH . "validate-session.php");
        $pet = $this->petDAO->GetById($IDPET);
       // var_dump($_FILES);
       /* if($_FILES['pic']['type']=="image/png" || $_FILES['pic']['type']=="image/jpg"){*/
    if( isset($_FILES['pic'])){
    if( $_FILES['pic']['error'] == 0){
        $dir = IMG_PATH;
        //var_dump(IMG_PATH);
        //$filename = $pet->getName(). $IDPET.".jpg";
       $filename = $_SESSION["loggedUser"]->GetUserName(). $IDPET . ".jpg";
        $newFile = $dir . $filename;
        if( move_uploaded_file($_FILES['pic']['tmp_name'], $newFile) ){
            //echo $_FILES['pic']['name'] . ' was uploaded and saved as '. $filename . '</br>';
            $pet->SetPicture($filename);
            $this->petDAO->Remove($IDPET);
            $petList = $this->petDAO->GetAll();
            array_push($petList,$pet);
            $this->petDAO->SaveData($petList);
            $this->ShowPerfilView($_FILES['pic']['name'] . ' was uploaded and saved as '. $filename . '</br>');
        
        }else{
            $this->ShowPerfilView("failed to move file error");
        }
    }else{
        $this->ShowPerfilView("failed to move file error");
    }   
}else{
    $this->ShowPerfilView("File NOT EXIST");
}
        $this->ShowPerfilView("failed to move file error"); //Modificar por user perfil
        /*}else{
            echo ("FORMATO NO ACEPTADO");
            require_once(VIEWS_PATH . "perfil-petlist.php");
        }*/
    }

        public function Remove($ID)
        {
            $this->petDAO->Remove($ID);

            $this->ShowPerfilView();
        }

        public function UploadVideo($MAX_FILE_SIZE,$IDPET){
            require_once(VIEWS_PATH . "validate-session.php");
            $pet = $this->petDAO->GetById($IDPET);
            //var_dump($_FILES);
         if( isset($_FILES['video'])){
         if( $_FILES['video']['error'] == 0){
            $dir = IMG_PATH;
            //var_dump(IMG_PATH);
           // $filename = "video".$pet->getName(). $IDPET . ".mp4";
            $filename = "video".$_SESSION["loggedUser"]->GetUserName(). $IDPET . ".jpg";
            $newFile = $dir . $filename;
            if( move_uploaded_file($_FILES['video']['tmp_name'], $newFile) ){
                //echo $_FILES['video']['name'] . ' was uploaded and saved as '. $filename . '</br>';
                $pet->setVideoPet($filename);
                $this->petDAO->Remove($IDPET);
                $petList = $this->petDAO->GetAll();
                array_push($petList,$pet);
                $this->petDAO->SaveData($petList);
                $this->ShowPerfilView($_FILES['video']['name'] . ' was uploaded and saved as '. $filename . '</br>');
            }else{
               $this->ShowPerfilView("failed to move file error");
            }
            
            
        }else{
            $this->ShowPerfilView("error to user - file error");
        }
        
    }else{
        $this->ShowPerfilView("failed to move file error");
    }
           $this->ShowPerfilView("failed to move file error");
    
        }
    
}



?>