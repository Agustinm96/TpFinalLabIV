<?php


namespace Models;

class Reserve{
    private $idReserve;
    private $idKeeper;
    private $startingDate;
    private $lastDate;
    private $arrayDays = array();
    private $isAvailable;

    public function getIdReserve(){
        return $this->idReserve;
    }

    public function setIdReserve($idReserve){
        $this->idReserve = $idReserve;
    }

    public function idKeeper(){
        return $this->idKeeper;
    }

    public function setIdKeeper($idKeeper){
        return $this->idKeeper;
    }

    public function getStartingDate(){
        return $this->startingDate;
    }

    public function setStartingDate($startingDate){
        $this->startingDate= $startingDate;
    }

    public function getLastDate(){
        return $this->lastDate;
    }

    public function setLastDate($lastDate){
        $this->lastDate= $lastDate;
    }

    public function getArrayDays(){
        return $this->arrayDays;
    }

    public function setArrayDays($arrayDays){
        $this->arrayDays= $arrayDays;
    }

    public function getIsAvailable(){
        return $this->isAvailable;
    }

    public function setIsAvailable($isAvailable){
        $this->isAvailable = $isAvailable;
    }

}

?>