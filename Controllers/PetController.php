<?php
namespace Controllers;



use Models\Pet as Pet;
use DAO\DogDAO as DogDAO;

class PetController {
private $dogController;

    public function __construct()
    {
        $this->$dogController = new DogController();
    }
    
    public function ShowPerfilView(){
        //require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "perfil-index.php");
    }

    public function ShowAddView() {
        //require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "add-pet.php");
    }

    public function ShowListView() {
        //require_once(VIEWS_PATH . "validate-session.php");
        $petList = $this->petDAO->GetAll();
        //require_once(VIEWS_PATH . "allpet-list.php");
    }

    /*public function Add($petType, $name, $birthDate, $observation)
        {
            $pet = new Pet();
            $pet->setPetType($petType);
            $pet->setName($name);
            $pet->setBirthDate($birthDate);
            $pet->setObservation($observation);
            $pet->setPicture("url(".IMG_PATH."no-image.jpg')"); //PREGUNTAR

            if($pet->getPetType()==="dog"){
            $this->dogController->Add($pet);
            }

           /// $this->ShowPerfilView(); Definir vista 
           //despues de agregar mascota, mandar a upload imagen video verificacion etc .
        } */ //Posible funcion que combine pet preguntar.

        public function Remove($id)
        {
            $this->petDAO->Remove($ID);

            $this->ShowPerfilView();
        }


}



?>