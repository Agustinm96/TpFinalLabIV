<?php

namespace DAO;


use Models\ReserveRequest;


class ReserveRequestDAO{
    private $fileName = ROOT . "/Data/requestReserves.json";
    private $requestReservesList = array();

    public function Add($requestReserve) {
        $this->RetrieveData();        
        
        $requestReserve->setId($this->GetNextId());

        array_push($this->requestReservesList, $requestReserve);

        $this->SaveData();   
    }

    public function Remove($id) {
        $this->RetrieveData();

        $this->requestReservesList = array_filter($this->requestReservesList, function($requestReserve) use($id) {
            return $requestReserve->getId() != $id;
        });

        $this->SaveData();
    }

    public  function GetAll() {
        $this->RetrieveData();
        return $this->requestReservesList;
    }

    public function GetById($id) {
        $this->RetrieveData();

        $aux = array_filter($this->requestReservesList, function($requestReserve) use($id) {
            return $requestReserve->getId() == $id;
        });

        $aux = array_values($aux);

        return (count($aux) > 0) ? $aux[0] : null;
    }

    private function SaveData() {
        $arrayEncode = array();
        
        foreach($this->requestReservesList as $requestReserve){
            $value["id"] = $requestReserve->getId();
            $value["availabilityId"] = $requestReserve->getAvailabilityId();
            $value["idPet"] = $requestReserve->getPetId();
                
            array_push($arrayEncode, $value);
            }
            

        $jsonContent = json_encode($arrayEncode, JSON_PRETTY_PRINT);
        file_put_contents($this->fileName, $jsonContent);
    }

    private function RetrieveData() {
        $this->requestReservesList = array();

        if(file_exists($this->fileName)) {
            $jsonContent = file_get_contents($this->fileName);
            $arrayDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

            foreach($arrayDecode as $value) {
                $requestReserve = new ReserveRequest();
                $requestReserve->setId($value["id"]);
                $requestReserve->setAvailabilityId($value["availabilityId"]);
                $requestReserve->setPetId($value["idPet"]);

                array_push($this->requestReservesList, $requestReserve);
            }
        }
    }

    private function GetNextId() {
        $id = 0;

        foreach($this->requestReservesList as $requestReserve) {
            $id = ($requestReserve->getId() > $id) ? $requestReserve->getId() : $id;
        }

        return $id + 1;
    }






}


?>