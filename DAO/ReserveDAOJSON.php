<?php

namespace DAO;

use Models\Keeper;
use Models\Availability;
use Models\Reserve;

class ReserveDAOJSON{
    private $fileName = ROOT . "/Data/reserves.json";
    private $reservesList = array();

    public function Add($reserve) {
        $this->RetrieveData();        
        
        $reserve->setId($this->GetNextId());

        array_push($this->reservesList, $reserve);

        $this->SaveData();
        
    }

    public function Remove($id) {
        $this->RetrieveData();

        $this->reservesList = array_filter($this->reservesList, function($reserve) use($id) {
            return $reserve->getId() != $id;
        });

        $this->SaveData();
    }

    public  function GetAll() {
        $this->RetrieveData();
        return $this->reservesList;
    }

    public function GetById($id) {
        $this->RetrieveData();

        $aux = array_filter($this->reservesList, function($reserve) use($id) {
            return $reserve->getId() == $id;
        });

        $aux = array_values($aux);

        return (count($aux) > 0) ? $aux[0] : null;
    }

    public function GetReserveArrayByAvailabilityId($availabilityId){
        $reserves=$this->GetAll();
        $arrayToReturn = array();

        foreach($reserves as $reserve){
                    if($reserve->getAvailabilityId() === $availabilityId){
                        array_push($arrayToReturn, $reserve); 
                        }
                    }
                
                
                
        //$arrFinal = array_unique($avaiableKeepersList,SORT_REGULAR);

        return $arrayToReturn;
    }

    private function SaveData() {
        $arrayEncode = array();
        
        foreach($this->reservesList as $reserve){
            $value["id"] = $reserve->getId();
            $value["availabilityId"] = $reserve->getAvailabilityId();
            $value["idPet"] = $reserve->getPetId();
                
            array_push($arrayEncode, $value);
            }
            

        $jsonContent = json_encode($arrayEncode, JSON_PRETTY_PRINT);
        file_put_contents($this->fileName, $jsonContent);
    }

    private function RetrieveData() {
        $this->reservesList = array();

        if(file_exists($this->fileName)) {
            $jsonContent = file_get_contents($this->fileName);
            $arrayDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach($arrayDecode as $value) {
                $reserve = new Reserve();
                $reserve->setId($value["id"]);
                $reserve->setAvailabilityId($value["availabilityId"]);
                $reserve->setPetId($value["idPet"]);

                array_push($this->reservesList, $reserve);
            }
            }
        }

        private function GetNextId() {
            $id = 0;

            foreach($this->reservesList as $reserve) {
                $id = ($reserve->getId() > $id) ? $reserve->getId() : $id;
            }

            return $id + 1;
        }

        public function Modify(Reserve $reserve) {
            $this->RetrieveData();
            
            $this->Remove($reserve->getId());
    
            array_push($this->reservesList, $reserve);
    
            $this->SaveData();
        }

    }

    


?>