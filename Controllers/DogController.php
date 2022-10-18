<?php
namespace Controllers;

use DAO\DogDAO as DogDAO;
use DAO\PetDAO as PetDAO;
use MODELS\Dog as Dog;

Class DogController{
private $dogDAO;
private $petDAO;

public function __construct()
    {
        $this->dogDAO = new DogDAO();
        $this->petDAO = new PetDAO();
    }

    public function ShowListView(){ //SOLO MUESTRA PERROS
      require_once(VIEWS_PATH . "validate-session.php");
      $petList = $this->petDAO->GetAll();
      require_once(VIEWS_PATH . "perfil-petlist.php");
    }

    public function ShowPerfilView(){
      require_once(VIEWS_PATH . "validate-session.php");
      $petList = $this->petDAO->GetByUserName($_SESSION["loggedUser"]->GetUserName());
      require_once(VIEWS_PATH . "perfil-petlist.php");
    }


    public function Add($name, $birthDate, $observation,$size,$race){
    require_once (VIEWS_PATH ."validate-session.php");
    $dog = new Dog();
    $dog->setPetType("dog");
    $dog->setName($name);
    $dog->setBirthDate($birthDate);
    $dog->setObservation($observation);
    $dog->setPicture(null); //PREGUNTAR
    $dog->setVaccinationPlan(null);
    $dog->setRace($race);
    $dog->setSize($size);
    $dog->setVideoPet(null);
    $dog->setUserName($_SESSION["loggedUser"]->GetUserName());
    $this->dogDAO->Add($dog);
    $this->ShowPerfilList();
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
          echo $_FILES['pic']['name'] . ' was uploaded and saved as '. $filename . '</br>';
          $pet->setVaccinationPlan($filename);
          $this->petDAO->Remove($IDPET);
          $petList = $this->petDAO->GetAll();
          array_push($petList,$pet);
          $this->petDAO->SaveData($petList);
          $this->ShowPerfilView();
      }else{
         echo ("failed to move file error");
         $this->ShowPerfilView();
      }
      
      
  }else{
      echo ("error to user - file error");
      $this->ShowPerfilView();
  }
  
}else{
  echo ("error message to user");
}
      $this->ShowPerfilView();

  }

}


?>