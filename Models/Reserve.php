<?php

namespace Models;

use Models\Availability;
use Models\Pet;

class Reserve{
    private $id;
    private Availability $availability;
    private Pet $pet;
    private $isActive;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getAvailability(){
        return $this->availability;
    }

    public function setAvailability($availability){
        $this->availability = $availability;
    }

    public function setPet($pet){
        $this->pet = $pet;
    }

    public function getPet(){
        return $this->pet;
    }

    public function setIsActive($isActive){
        $this->isActive = $isActive;
    }

    public function getIsActive(){
        return $this->isActive;
    }
    
}


?>