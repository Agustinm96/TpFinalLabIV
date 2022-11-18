<?php
namespace Controllers;
use Models\Pet as Pet;
use Models\PetType as PetType;
use DAO\PetTypeDAO as PetTypeDAO;


class PetTypeController {
    public $petTypeDAO;
    private $ownerController;

    public function __construct()
    {
        $this->petTypeDAO = new petTypeDAO();
        $this->ownerController = new OwnerController();
    }

    public function ShowAddView($message = ""){
        require_once(VIEWS_PATH . "validate-session.php");
        $owner = $this->ownerDAO->GetByIdUser(($_SESSION["loggedUser"]->getId()));
        $ownerBoolean = $this->checkingIfAreInvoicesToPay($owner);
        require_once(VIEWS_PATH . "add-choice.php");
      }


    public function Add($id,$petName){ //FUNCION SETEA UN PETYPE DEPENDIENDO DEL ID;
        $petType = new PetType();
        if(!is_null($id)){
            require_once(VIEWS_PATH . "validate-session.php");
            $petType->setPetTypeId($id);
            $petType->setPetTypeName($petName); //seteamos petname en dog;
            $owner = $this->ownerController->ownerDAO->GetByIdUser(($_SESSION["loggedUser"]->getId()));
            $ownerBoolean = $this->ownerController->checkingIfAreInvoicesToPay($owner);
        require_once(VIEWS_PATH . "add-pet.php");
    }else{
       $this->ShowAddView("ERROR AL INGRESAR TIPO DE MASCOTA");
    }
    }

}

?>