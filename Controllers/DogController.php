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


    public function ShowListView(){
      //require_once(VIEWS_PATH . "validate-session.php");
      $petList = $this->petDAO->GetAll();
      require_once(VIEWS_PATH . "perfil-petlist.php");
    }

    public function ShowPerfilList(){
      //require_once(VIEWS_PATH . "validate-session.php");
      $petList = $this->petDAO->GetAll();
      require_once(VIEWS_PATH . "perfil-petlist.php");
    }


    public function Add($name, $birthDate, $observation,$size,$race){
    require_once (VIEWS_PATH ."validate-session.php");
 //$IDUser = 1; // $_SESSION["loggedUser"]->getId();
    $dog = new Dog();
    $dog->setPetType("dog");
    $dog->setName($name);
    $dog->setBirthDate($birthDate);
    $dog->setObservation($observation);
    $dog->setPicture("url(".IMG_PATH."no-image.jpg')"); //PREGUNTAR
    $dog->setVaccinationPlan("url(".IMG_PATH."no-image.jpg')");
    $dog->setRace($race);
    $this->dogDAO->Add($dog);
    $this->ShowPerfilList();
    }



}


?>