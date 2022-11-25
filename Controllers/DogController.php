<?php
namespace Controllers;

use DAO\DogDAO as DogDAO;
use DAO\PetDAO as PetDAO;
use Controllers\PetController as PetController;
use Controllers\PetTypeController as PetTypeController;
use MODELS\Dog as Dog;
use MODELS\User as User;
use MODELS\PetType as PetType;

Class DogController{
private $dogDAO;
private $petController;
private $petTypeController;
private $petDAO;

public function __construct()

    {
        $this->dogDAO = new DogDAO();
        $this->petController = new PetController();
        $this->petTypeController = new PetTypeController();
        $this->petDAO = new PetDAO();
    }

    /*public function ShowListView(){ //SOLO MUESTRA PERROS
      require_once(VIEWS_PATH . "validate-session.php");
      //$petList = $this->petDAO->GetAllDog();
      require_once(VIEWS_PATH . "perfil-petlist.php");
    } */ // Futura implementacion de ver solo perros gatos o cobayas.

    public function ShowPerfilView($message = ""){
      require_once(VIEWS_PATH . "validate-session.php");
      $petList = $this->petDAO->GetById_User($_SESSION["loggedUser"]->getId());
      require_once(VIEWS_PATH . "perfil-petlist.php");
    }

    public function ShowAddView(PetType $petType, $message = "") {
      require_once(VIEWS_PATH . "validate-session.php");
      require_once(VIEWS_PATH . "add-pet.php");
  }

    public function Add($name, $birthDate, $observation,$size,$race,$petType){
    require_once (VIEWS_PATH ."validate-session.php");
    $checkDate = $this->petController->petDAO->validateDate($birthDate);
    if($checkDate==true){
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
    $this->ShowPerfilView("Se añadio correctamente el perro: " .$dog->getName());
  }else{
    $petTypeAux = new PetType();
    $petTypeAux = $this->petTypeController->petTypeDAO->GetByPetTypeId($petType);
    $this->ShowAddView($petTypeAux,"Error fecha ingresada no valida \n
    Solo se aceptan mascotas con mas de 3 meses de edad");
  }
    }

    public function Modify($id_pet,$name, $birthDate, $observation,$size,$race){
      require_once (VIEWS_PATH ."validate-session.php");
      $checkDate = $this->petController->petDAO->validateDate($birthDate);
      if($checkDate==true){
      $this->dogDAO->Modify($name, $birthDate, $observation,$size,$race, $id_pet);
      $this->ShowPerfilView("Se modifico correctamente el perro ");
    }else{
      $this->ShowPerfilView("Error fecha ingresada no valida \n
      Solo se aceptan mascotas con mas de 3 meses de edad");
    }
      }

    public function UploadVaccination($MAX_FILE_SIZE,$IDPET){
      require_once(VIEWS_PATH . "validate-session.php");
if( isset($_FILES['pic'])){
  $fileType = $_FILES['pic']['type'];
 if(($fileType == "image/gif")||($fileType== "image/jpeg")||
 ($fileType == "image/jpg")|| ($fileType == "image/png")){

  if( $_FILES['pic']['error'] == 0){
      $dir = IMG_PATH;
     $filename = "VAC".$_SESSION["loggedUser"]->GetUserName(). $IDPET . ".jpg";
      $newFile = $dir . $filename;
      if( move_uploaded_file($_FILES['pic']['tmp_name'], $newFile) ){
          $this->dogDAO->uploadVaccinationPlan($filename,$IDPET);
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