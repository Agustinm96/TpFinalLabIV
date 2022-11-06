<?php

namespace DAO;

use Models\Keeper;
use Models\Availability;

class AvailabilityDAO{
    private $fileName = ROOT . "/Data/availability.json";
    private $availabilityList = array();

    public function Add($availability) {
        $this->RetrieveData();        
        
        $availability->setId($this->GetNextId());

        array_push($this->availabilityList, $availability);

        $this->SaveData();
        
    }

    public function Remove($id) {
        $this->RetrieveData();

        $this->availabilityList = array_filter($this->availabilityList, function($availability) use($id) {
            return $availability->getId() != $id;
        });

        $this->SaveData();
    }

    public  function GetAll() {
        $this->RetrieveData();
        return $this->availabilityList;
    }

    public function GetById($availabilityId) {
        $this->RetrieveData();

        $aux = array_filter($this->availabilityList, function($availability) use($availabilityId) {
            return $availability->getId() == $availabilityId;
        });

        $aux = array_values($aux);

        return (count($aux) > 0) ? $aux[0] : null;
    }

    private function SaveData() {
        $arrayEncode = array();
        
        foreach($this->availabilityList as $availability){
            $value["idKeeper"] = $availability->getIdKeeper();
            $value["id"] = $availability->getId();
            $value["date"] = $availability->getDate();
            $value["available"] = $availability->getAvailable();
            $value["reserveRequest"] = $availability->getReserveRequest();
            $value["petList"] = $availability->getPetList();
                
            array_push($arrayEncode, $value);
            }
            

        $jsonContent = json_encode($arrayEncode, JSON_PRETTY_PRINT);
        file_put_contents($this->fileName, $jsonContent);
    }

    private function RetrieveData() {
        $this->availabilityList = array();

        if(file_exists($this->fileName)) {
            $jsonContent = file_get_contents($this->fileName);
            $arrayDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach($arrayDecode as $value) {
                $availability = new Availability();
                $availability->setIdKeeper($value["idKeeper"]);
                $availability->setId($value["id"]);
                $availability->setDate($value["date"]);
                $availability->setAvailable($value["available"]);
                $availability->setReserveRequest($value["reserveRequest"]);
                $availability->setPetList($value["petList"]);
                array_push($this->availabilityList, $availability);
            }
                
            }
        }

        public function GetByIdKeeper($idKeeper){
            $availabilityList = $this->GetAll();
            $finalArray = array();

            foreach($availabilityList as $availability){
                if($availability->getIdKeeper() == $idKeeper){
                    if($availability->getAvailable()==true){
                        array_push($finalArray, $availability);
                    }
                }
            }
            usort($finalArray, $this->object_sorter('id'));

            return $finalArray;
        }

        function object_sorter($clave,$orden=null) {
            return function ($a, $b) use ($clave,$orden) {
                $result=  ($orden=="DESC") ? strnatcmp($b->$clave, $a->$clave) :  strnatcmp($a->$clave, $b->$clave);
                return $result;
            };
        }


        public function GetByKeeperUserName($userName) {
            $this->RetrieveData();

            $aux = array_filter($this->availabilityList, function($availability) use($userName) {
                return $availability->getUserName() == $userName;
            });

            $aux = array_values($aux);

            return (count($aux) > 0) ? $aux[0] : null;
        }

        private function GetNextId() {
            $id = 0;

            foreach($this->availabilityList as $availability) {
                $id = ($availability->getId() > $id) ? $availability->getId() : $id;
            }

            return $id + 1;
        }

        public function Modify(Availability $availability) {
            $this->RetrieveData();
            
            $this->Remove($availability->getId());
    
            array_push($this->availabilityList, $availability);
    
            $this->SaveData();
        }

    }

    


?>