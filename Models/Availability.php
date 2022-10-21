<?php


namespace Models;

use Models\Keeper;

class availability{
    private $id;
    private $date;
    private $available; //boolean
    private $userName; //recien agregado 
    private $petList; //??

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

    public function getAvailabilityId(){
        return $this->id;
    }

    public function setAvailabilityId($id){
        $this->id = $id;
    }
}

?>