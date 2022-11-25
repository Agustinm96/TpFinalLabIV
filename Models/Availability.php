<?php


namespace Models;

use Models\Keeper;
use Models\Pet;

class availability{
    private Keeper $keeper;
    public $id;
    private $date;
    private $available; //boolean
    //private Pet $pet;

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

    public function setKeeper($keeper){
        $this->keeper = $keeper;
    }

    public function getKeeper(){
        return $this->keeper;
    }

    /*public function getPet(){
        return $this->pet;
    }

    public function setPet($pet){
        $this->pet = $pet;
    }*/
}

?>