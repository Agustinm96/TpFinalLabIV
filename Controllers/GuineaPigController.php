<?php
namespace Controllers;

use DAO\GuineaPigDAO as GuineaPigDAO;
use DAO\PetDAO as PetDAO;
use MODELS\GuineaPig as GuineaPig;
use MODELS\User as User;
use MODELS\PetType as PetType;
use Controllers\PetController as PetController;
use Controllers\PetTypeController as PetTypeController;

Class GuineaPigController{
private $guineapigDAO;
private $petController;
private $petTypeController;
private $petDAO;

public function __construct()
    {
        $this->guineapigDAO = new GuineaPigDAO();
        $this->petController = new PetController();
        $this->petTypeController = new PetTypeController();
        $this->petDAO = new PetDAO();

    }

    public function ShowPerfilView($message = ""){
      require_once(VIEWS_PATH . "validate-session.php");
      $petList = $this->petDAO->GetById_User($_SESSION["loggedUser"]->GetId());
      require_once(VIEWS_PATH . "perfil-petlist.php");
    }

    public function ShowAddView(PetType $petType ,$message = "") {
      require_once(VIEWS_PATH . "validate-session.php");
      require_once(VIEWS_PATH . "add-pet.php");
  }


    public function Add($name, $birthDate, $observation,$gender,$heno,$petType){
    require_once (VIEWS_PATH ."validate-session.php");
    $checkDate = $this->petController->petDAO->validateDate($birthDate);
    if($checkDate==true){
    $guineaPig = new GuineaPig(); //Deberia llegar el type
    $petTypeAux = new PetType();
    $petTypeAux->setPetTypeId($petType);
    $user = new User();
    $user->setId($_SESSION["loggedUser"]->GetId());
    $guineaPig->setName($name);
    $guineaPig->setBirthDate($birthDate);
    $guineaPig->setObservation($observation);
    $guineaPig->setPicture(null); //PREGUNTAR
    $guineaPig->setGender($gender);
    $guineaPig->setHeno($heno);
    $guineaPig->setVideoPet(null);
    $guineaPig->setId_User($user);
    $guineaPig->setPetType($petTypeAux);
    $this->guineapigDAO->Add($guineaPig);
    $this->ShowPerfilView("Se añadio correctamente el cobayo: " .$guineaPig->getName());
    }else{
      $petTypeAux = new PetType();
      $petTypeAux = $this->petTypeController->petTypeDAO->GetByPetTypeId($petType);
      $this->ShowAddView($petTypeAux,"Error fecha ingresada no valida \n
      Solo se aceptan mascotas con mas de 3 meses de edad");
    }
    }

    public function Modify($id_pet,$name, $birthDate, $observation,$heno,$gender){
        require_once (VIEWS_PATH ."validate-session.php");
        $checkDate = $this->petController->petDAO->validateDate($birthDate);
        if($checkDate==true){
        $this->guineapigDAO->Modify($name, $birthDate, $observation,$heno,$gender, $id_pet);
        $this->ShowPerfilView("Se modifico correctamente el perro ");
      }else{
        $this->ShowPerfilView("Error fecha ingresada no valida \n
        Solo se aceptan mascotas con mas de 3 meses de edad");
      }
        }


}


?>