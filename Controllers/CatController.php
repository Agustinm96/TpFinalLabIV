<?php
namespace Controllers;

use DAO\CatDAO as CatDAO;
use DAO\PetDAO as PetDAO;
use MODELS\Cat as Cat;
use MODELS\PetType as PetType;
use Models\User as User;

Class CatController{
private $catDAO;
private $petDAO;

public function __construct()
    {
        $this->catDAO = new CatDAO();
        $this->petDAO = new PetDAO();
    }

    public function ShowListView(){ //SOLO MUESTRA GATOS
      require_once(VIEWS_PATH . "validate-session.php");
      // $petList = $this->petDAO->GetAllCats();
      require_once(VIEWS_PATH . "perfil-petlist.php");
    }

    public function ShowPerfilView($message = ""){
      require_once(VIEWS_PATH . "validate-session.php");
      $petList = $this->petDAO->GetById_User($_SESSION["loggedUser"]->GetId());
      require_once(VIEWS_PATH . "perfil-petlist.php");
    }


    public function Add($name, $birthDate, $observation, $race,$petType){
    require_once (VIEWS_PATH ."validate-session.php");
    $cat = new Cat(); //Deberia llegar el type
    $petTypeAux = new PetType();
    $petTypeAux->setPetTypeId($petType);
    $user = new User();
    $user->setId($_SESSION["loggedUser"]->GetId());
    $cat->setName($name);
    $cat->setBirthDate($birthDate);
    $cat->setObservation($observation);
    $cat->setPicture(null); //PREGUNTAR
    $cat->setVaccinationPlan(null);
    $cat->setRace($race);
    $cat->setVideoPet(null);
    $cat->setId_User($user);
    var_dump($petType);
    $cat->setPetType($petTypeAux);
    $this->catDAO->Add($cat);
    $this->ShowPerfilView("Se añadio correctamente el gato :" .$cat->getName());
    }

    public function UploadVaccination($MAX_FILE_SIZE,$IDPET){
      require_once(VIEWS_PATH . "validate-session.php");
      $pet = $this->petDAO->GetById($IDPET);
      //var_dump($_FILES);
if( isset($_FILES['pic'])){
  if( $_FILES['pic']['error'] == 0){
      $dir = IMG_PATH;
      //var_dump(IMG_PATH);
      //$filename = "VAC".$pet->getName(). $IDPET . ".jpg";
     $filename = "VAC".$_SESSION["loggedUser"]->GetUserName(). $IDPET . ".jpg";
     //var_dump($filename);
      $newFile = $dir . $filename;
      if( move_uploaded_file($_FILES['pic']['tmp_name'], $newFile) ){
          $pet->setVaccinationPlan($filename);
          $this->petDAO->Remove($IDPET);
          $petList = $this->petDAO->GetAll();
          array_push($petList,$pet);
          $this->petDAO->SaveData($petList);
          $this->ShowPerfilView($_FILES['pic']['name'] . ' was uploaded and saved as '. $filename . '</br>');
      }else{
         $this->ShowPerfilView("failed to move file error");
      }   
  }else{
      $this->ShowPerfilView("error to user - file error");
  }
  
}else{
  $this->ShowPerfilView("error to user - file error");
}
      $this->ShowPerfilView("File NOT EXIST");

  }

}


?>