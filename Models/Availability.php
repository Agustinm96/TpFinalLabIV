<?php


namespace Models;

use Models\Keeper;

class availability{
    private $idKeeper;
    public $id;
    private $date;
    private $available; //boolean
    private $reserveRequest; //boolean
    private $petList = array(); //guarda solo el id de la pet

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getDate(){
        return $this->date;
    }

    public function setDate($date){
        $this->date = $date;
    }

    public function getAvailable(){
        return $this->available;
    }

    public function setAvailable($available){
        $this->available = $available;
    }

    public function setIdKeeper($idKeeper){
        $this->idKeeper = $idKeeper;
    }

    public function getIdKeeper(){
        return $this->idKeeper;
    }

    public function getPetList(){
        return $this->petList;
    }

    public function setPetList($petList){
        $this->petList = $petList;
    }

    public function getReserveRequest(){
        return $this->reserveRequest;
    }

    public function setReserveRequest($reserveRequest){
        $this->reserveRequest = $reserveRequest;
    }

}

?>