<?php
namespace Controllers;

use DAO\DogDAO as DogDAO;
use DAO\PetDAO as PetDAO;
use Controller\PetController as PetController;
use MODELS\Dog as Dog;
use MODELS\User as User;
use MODELS\PetType as PetType;

Class DogController{
private $dogDAO;
private $petDAO; // no deberia ir
private $petController;

public function __construct()

    {
        $this->dogDAO = new DogDAO();
        $this->petDAO = new PetDAO();
        $this->petController = new PetController();
    }

    /*public function ShowListView(){ //SOLO MUESTRA PERROS
      require_once(VIEWS_PATH . "validate-session.php");
      //$petList = $this->petDAO->GetAllDog();
      require_once(VIEWS_PATH . "perfil-petlist.php");
    } */ // Futura implementacion de ver solo perros gatos o cobayas.

    public function ShowPerfilView($message = ""){
      require_once(VIEWS_PATH . "validate-session.php");
      $petList = $this->petDAO->GetById_User($_SESSION["loggedUser"]->GetId());
      require_once(VIEWS_PATH . "perfil-petlist.php");
    }

    public function ShowAddView($message = "") {
      require_once(VIEWS_PATH . "validate-session.php");
      require_once(VIEWS_PATH . "add-choice.php");
  }

    public function Add($name, $birthDate, $observation,$size,$race,$petType){
    require_once (VIEWS_PATH ."validate-session.php");
    $checkDate = $this->petController->petDAO->validateDate($birthDate);
    var_dump($checkDate);
    if($checkDate>=3){
    $dog = new Dog();
    $user = new User();
    $user->setId($_SESSION["loggedUser"]->GetId());
    $petTypeAux = new PetType();
    $petTypeAux->setPetTypeId($petType);
    $dog->setName($name);
    $dog->setBirthDate($birthDate);
    $dog->setObservation($observation);
    $dog->setPicture(null); //PREGUNTAR
    $dog->setVaccinationPlan(null);
    $dog->setRace($race);
    $dog->setSize($size);
    $dog->setVideoPet(null);
    $dog->setId_User($user);
    $dog->setPetType($petTypeAux);
    $this->dogDAO->Add($dog);
    $this->ShowPerfilView("Se añadio correctamente el perro :" .$dog->getName());
    }else{
      $this->ShowAddView("Error fecha ingresada no valida \n
      Solo se aceptan mascotas con mas de 3 meses de edad");
    }
    }

    public function UploadVaccination($MAX_FILE_SIZE,$IDPET){
      require_once(VIEWS_PATH . "validate-session.php");
      //$pet = $this->petDAO->GetById($IDPET);
      //var_dump($_FILES);
if( isset($_FILES['pic'])){
  $fileType = $_FILES['pic']['type'];
 if(!((strpos($fileType, "gif") || strpos($fileType, "jpeg")|| strpos($fileType, "jpg")|| strpos($fileType, "png")))){

  if( $_FILES['pic']['error'] == 0){
      $dir = IMG_PATH;
      //var_dump(IMG_PATH);
      //$filename = "VAC".$pet->getName(). $IDPET . ".jpg";
     $filename = "VAC".$_SESSION["loggedUser"]->GetUserName(). $IDPET . ".jpg";
     //var_dump($filename);
      $newFile = $dir . $filename;
      if( move_uploaded_file($_FILES['pic']['tmp_name'], $newFile) ){
          $this->petController->dogDAO->uploadVaccinationPlan($filename,$IDPET);
          //$this->dogDAO->uploadVaccinationPlan($filename,$IDPET);
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

}



?>