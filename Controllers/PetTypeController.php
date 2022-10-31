<?php
namespace Controllers;
use Models\Pet as Pet;
use Models\PetType as PetType;
use DAO\PetTypeDAO as PetTypeDAO;


class PetTypeController {
    private $petTypeDAO;

    public function __construct()
    {
        $this->petTypeDAO = new petTypeDAO();
    }

    public function ShowAddView($message = ""){
        require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "add-choice.php");
      }


    public function Add($id,$petName){
        $petType = new PetType();
        if(!is_null($id)){
            require_once(VIEWS_PATH . "validate-session.php");
            $petType->setPetTypeId($id);
            $petType->setPetTypeName($petName); //seteamos petname en dog;
        require_once(VIEWS_PATH . "add-pet.php");
    }else{
       $this->ShowAddView("ERROR AL INGRESAR TIPO DE MASCOTA");
    }
    }


}

?>