<?php

namespace Controllers;

use Models\Reserve;
use Models\Availability;
use Models\Keeper;
use DAO\ReserveDAO;

class ReserveController{
    private $reserveDAO;
    private $availabilityController;
    private $keeperController;
    private $petController;
    private $reserveRequestController;

    public function __construct() {
        $this->reserveDAO = new ReserveDAO();
        $this->availabilityController = new AvailabilityController();
        $this->keeperController = new KeeperController();
        $this->petController = new PetController();
        $this->reserveRequestController = new ReserveRequestController();
    }

    public function ShowReserveView(){
        require_once(VIEWS_PATH . "validate-session.php");
            if($_SESSION["loggedUser"]->getUserType()->getId()==2){
                $keeper = $this->keeperController->keeperDAO->getByIdUser(($_SESSION["loggedUser"]->getId()));
                $boolean = $this->keeperController->checkingRequests($keeper);
            }
            $reserveList = $this->loadReserveList($keeper->getIdKeeper());
            require_once(VIEWS_PATH . "keeper-reserve.php");
    }

    public function ShowModifyAvailabilityView($message = "") {
        require_once(VIEWS_PATH . "validate-session.php");
        $keeper = $this->keeperController->keeperDAO->getByIdUser(($_SESSION["loggedUser"]->getId()));
        $boolean = $this->keeperController->checkingRequests($keeper);
        $array = $this->checkingReserves($keeper);
        require_once(VIEWS_PATH . "keeper-modify-availability.php");
         
    }

    public function Add (Reserve $reserve){
        require_once(VIEWS_PATH . "validate-session.php");
        
        $this->reserveDAO->Add($reserve);
        
    }

    public function loadReserveList($idKeeper){
        $reservesList = $this->reserveDAO->GetAll();
        $arrayToReturn = array();
        
        foreach($reservesList as $reserve){
            $availabilityAux = $this->availabilityController->availabilityDAO->GetById($reserve->getAvailabilityId());
            if($availabilityAux->getIdKeeper() == $idKeeper){
                $reserveStored["date"] = $availabilityAux->getDate();

                $pet = $this->petController->petDAO->GetById($reserve->getPetId()); 

                $reserveStored["userName"] = $pet->getUserName(); //me valgo de la pet para conseguir estos datos
                $reserveStored["petName"] = $pet->getName();
                $reserveStored["petType"] = $pet->getPetType()->getPetTypeName();

                array_push($arrayToReturn, $reserveStored);
            }
        }
        return $arrayToReturn;
    }

    public function checkingReserves($keeper){
        $reservesArray = $this->reserveDAO->GetAll();
        $arrayToReturn = array();

        foreach($reservesArray as $reserve){
            $availabilityAux = $this->availabilityController->availabilityDAO->GetById($reserve->getId());
            if($availabilityAux->getIdKeeper() == $keeper->getIdKeeper()){
                array_push($arrayToReturn, $reserve);
            } 
        }
        
        return $arrayToReturn;
    }

    public function checkingReservesAmount($keeper, $id)//validates in keeperController->confirmingReserve
    {   
        $array = $this->reserveDAO->GetReserveArrayByAvailabilityId($id);
        $counter = count($array);
        
        if($counter >= $keeper->getPetsAmount()){ //si cantidad de reservas es igual o + que las mascotas que el keeper esta disupuesto a estudiar --> false
            return false;
        }else{
            return true;
        }
    }

    public function checkingReserveRedundancy(Reserve $reserve){
        $availabilityToConfirm = $this->availabilityController->availabilityDAO->GetById($reserve->getAvailabilityId());
        $keeperFromReserveToConfirm = $this->keeperController->keeperDAO->GetById($availabilityToConfirm->getIdKeeper());
        $boolean = true;

        $reservesList = $this->reserveDAO->GetAll();
        foreach($reservesList as $doneReserves){
            $availabilityAux = $this->availabilityController->availabilityDAO->GetById($doneReserves->getAvailabilityId());
            $keeperRConfirmed = $this->keeperController->keeperDAO->GetById($availabilityAux->getIdKeeper());
            
            if($availabilityAux->getDate() == $availabilityToConfirm->getDate() && $keeperRConfirmed->getIdKeeper() == $keeperFromReserveToConfirm->getIdKeeper()){
                if($doneReserves->getPetId() == $reserve->getPetId()){
                    $boolean = false;
                }
                
            }
        }
        return $boolean;
    }

    public function validatePetType(Reserve $reserve, $keeper){
        $availabilityToConfirm = $this->availabilityController->availabilityDAO->GetById($reserve->getAvailabilityId());
        $boolean = true;

        $reservesList = $this->reserveDAO->GetAll();
        foreach($reservesList as $doneReserves){
            $availabilityAux = $this->availabilityController->availabilityDAO->GetById($doneReserves->getAvailabilityId());
            
            if($availabilityAux->getDate() == $availabilityToConfirm->getDate() && $availabilityAux->getIdKeeper() == $keeper->getIdKeeper()){
                    
                    $petFromReserveToConfirm = $this->petController->petDAO->GetById($reserve->getPetId()); //recibo la pet que quiero aceptar reserva
                    $petAlreadyReserved = $this->petController->petDAO->GetById($doneReserves->getPetId());

                    if($petFromReserveToConfirm->getPetType()->getPetTypeId() != $petAlreadyReserved->getPetType()->getPetTypeId()){
                        $boolean = false;
                    }
                }
            }
            return $boolean;
        }

        public function modifyingReserve($date, $userName, $petName, $petType, $petId, $availabilityId, $reserveId, $value){
            
            $keeper = $this->keeperController->keeperDAO->GetByIdUser($_SESSION["loggedUser"]->getId());
            $availability = $this->availabilityController->availabilityDAO->GetById($availabilityId);
            $petAux = $this->petController->petDAO->GetById($petId);
            
            if($value==1){
                $this->confirmingReserve($keeper, $availability, $petAux, $reserveId);
            }elseif($value==2){
                $this->cancelingReserve($keeper, $availability, $petAux, $reserveId);
            }
        }

        public function cancelingReserve($keeper, $availability, $pet, $reserveId){

            $this->reserveRequestController->reserveRequestDAO->Remove($reserveId);
            $message = 'Reserve succesfully rejected!';
            $this->keeperController->ShowPendingReserves($message);
        }


        public function confirmingReserve($keeper, $availability, $pet, $reserveId){

            $reserve = new Reserve();
            $reserve->setAvailabilityId($availability->getId());
            $reserve->setPetId($pet->getIDPET());

            $boolean = $this->checkingReserveRedundancy($reserve);
            $boolean2 =  $this->checkingReservesAmount($keeper, $availability->getId());
            $boolean3 = $this->validatePetType($reserve, $keeper);
           

            if($boolean && $boolean2 && $boolean3){

                $this->reserveRequestController->reserveRequestDAO->Remove($reserveId); //elimino de la reserve request list esa peticion de reserva
                
                $booleanAux = $this->checkingReservesAmount($keeper, $availability->getId());
                if(!$booleanAux){
                    $availability->setAvailable(false);
                }

                $this->Add($reserve);
                $this->keeperController->keeperDAO->Modify($keeper);
                $this->availabilityController->availabilityDAO->Modify($availability);
                $message = "DONE! Accepted reserve";
                $this->keeperController->ShowPendingReserves($message);
            }else{
                if(!$boolean){
                    $message = "ERROR: You've already accepted this pet on that date.";
                }elseif(!$boolean2){
                    $message = "ERROR: the date is already full";
                }elseif(!$boolean3){
                    $message = "ERROR: you can only accept another pet of the same type";
                }
                $this->keeperController->ShowPendingReserves($message);
            }
        }
    }

?>