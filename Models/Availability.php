<?php


namespace Models;

use Models\Keeper;

class availability{
    private $date;
    private $available; //boolean
    private $reserveRequest; //boolean
    private $userName = array();  
    private $petList = array(); 
    private $finalCustomers = array();

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

    public function setUserName($userName){
        $this->userName = $userName;
    }

    public function getUserName(){
        return $this->userName;
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

    public function getFinalCustomers(){
        return $this->finalCustomers;
    }

    public function setFinalCustomers($finalCustomers){
        $this->finalCustomers = $finalCustomers;
    }

}

?>