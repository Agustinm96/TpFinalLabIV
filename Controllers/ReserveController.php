<?php

namespace Controllers;

use Models\Reserve;
use Models\Availability;
use Models\Keeper;
use DAO\ReserveDAO;

class ReserveController{
    public $reserveDAO;
    private $petController;
    private $availabilityController;

    public function __construct(){
        $this->reserveDAO = new ReserveDAO();
        $this->petController = new PetController();
        $this->availabilityController = new AvailabilityController();
        }

        public function loadAllReservesFromKeeper($idKeeper){
            $reservesList = $this->reserveDAO->GetAll();
            $arrayToReturn = array();
            
            if(is_array($reservesList)){
                foreach($reservesList as $reserve){
                $availabilityAux = $this->availabilityController->availabilityDAO->GetById($reserve->getAvailability()->getId());
                if($availabilityAux->getKeeper()->getIdKeeper() == $idKeeper){
                    array_push($arrayToReturn, $reserve);
                }
            }
            }elseif($reservesList){
                $availabilityAux = $this->availabilityController->availabilityDAO->GetById($reservesList->getAvailability()->getId());
                if($availabilityAux->getKeeper()->getIdKeeper() == $idKeeper){
                    array_push($arrayToReturn, $reserve);
                }
            }
            return $arrayToReturn;
        }
    
        

        public function loadDoneReservesList($idKeeper){
            $reservesList = $this->reserveDAO->GetAll();
            $arrayToReturn = array();
            
            if(is_array($reservesList)){
                foreach($reservesList as $reserve){
                $availabilityAux = $this->availabilityController->availabilityDAO->GetById($reserve->getAvailability()->getId());
                if($availabilityAux->getKeeper()->getIdKeeper() == $idKeeper && $reserve->getIsActive() == 0){
                    $reserveStored["date"] = $availabilityAux->getDate();
    
                    $pet = $this->petController->petDAO->GetById($reserve->getPet()->getId_Pet()); 
    
                    $reserveStored["petName"] = $pet->getName();
                    $reserveStored["petType"] = $pet->getPetType()->getPetTypeId();
    
                    array_push($arrayToReturn, $reserveStored);
                }
            }
            }elseif($reservesList){
                $availabilityAux = $this->availabilityController->availabilityDAO->GetById($reservesList->getAvailability()->getId());
                if($availabilityAux->getKeeper()->getIdKeeper() == $idKeeper  && $reservesList->getIsActive() == 0){
                    $reserveStored["date"] = $availabilityAux->getDate();
    
                    $pet = $this->petController->petDAO->GetById($reservesList->getPet()->getId_Pet()); 
                    $reserveStored["petName"] = $pet->getName();
                    $reserveStored["petType"] = $pet->getPetType()->getPetTypeId();
    
                    array_push($arrayToReturn, $reserveStored);
                }
            }
            
            return $arrayToReturn;
        }

        public function checkingReserves($keeper){
            $reservesArray = $this->reserveDAO->GetAll();
            $arrayToReturn = array();
    
            if(is_array($reservesArray)){
                foreach($reservesArray as $reserve){
                    $availabilityAux = $this->availabilityController->availabilityDAO->GetById($reserve->getAvailability()->getId());
                    if($availabilityAux){
                        if($availabilityAux->getKeeper()->getIdKeeper() == $keeper->getIdKeeper() && $reserve->getIsActive()==0){
                        array_push($arrayToReturn, $reserve);
                        } 
                    }
                    
                } 
            }elseif($reservesArray){
                $availabilityAux = $this->availabilityController->availabilityDAO->GetById($reserve->getAvailability()->getId());
                    if($availabilityAux){
                        if($availabilityAux->getKeeper()->getIdKeeper() == $keeper->getIdKeeper() && $reserve->getIsActive()==0){
                        array_push($arrayToReturn, $reserve);
                        } 
                    }
            }
            
            return $arrayToReturn;
        }

        public function checkingReservesAmount($keeper, $id)//validates in confirmingReserve
    {   
        $array = $this->reserveDAO->GetDoneReserveArrayByAvailabilityId($id);
        $counter=0;
        
        if(is_array($array)){
            $counter = count($array);
        }
        
        if($counter >= $keeper->getPetsAmount()){ //si cantidad de reservas es igual o + que las mascotas que el keeper esta disupuesto a estudiar --> false
            return false;
        }else{
            return true;
        }
    }

    public function validatePetType(Reserve $reserve, $keeper){
        $availabilityToConfirm = $this->availabilityController->availabilityDAO->GetById($reserve->getAvailability()->getId());
        $boolean = true;

        $reservesList = $this->reserveDAO->GetAll();
        
        if($reservesList){
            foreach($reservesList as $doneReserves){
                if($doneReserves->getIsActive()==0){
                    $availabilityAux = $this->availabilityController->availabilityDAO->GetById($doneReserves->getAvailability()->getId());
            
                if($availabilityAux->getDate() == $availabilityToConfirm->getDate() && $availabilityAux->getKeeper()->getIdKeeper() == $keeper->getIdKeeper()){
                        $petFromReserveToConfirm = $this->petController->petDAO->GetById($reserve->getPet()->getId_Pet()); //recibo la pet que quiero aceptar reserva
                        $petAlreadyReserved = $this->petController->petDAO->GetById($doneReserves->getPet()->getId_Pet()); //pet que ya esta reservada
                        
                        if($petFromReserveToConfirm->getPetType()->getPetTypeId() != $petAlreadyReserved->getPetType()->getPetTypeId()){
                            $boolean = false;
                        }
                    }
                }
            }
        }    
        return $boolean;
        }

        

    }

?>