<?php
namespace Controllers;

use DAO\DogDAO as DogDAO;

Class DogController{
private $dogDAO;

public function __construct()
    {
        $this->$dogDAO = new DogDAO();
    }


    public function ShowPerfilList(){
      //require_once(VIEWS_PATH . "validate-session.php");
      require_once(VIEWS_PATH . "perfil-petlist.php");
    }


    public function Add($name, $birthDate, $observation,$size,$race){
    $dog = new Dog($pet);
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