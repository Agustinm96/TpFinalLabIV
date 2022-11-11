<?php

namespace Models;

use Models\Availability;
use Models\Pet;

class Reserve{
    private $id;
    private $availabilityId;
    private $petId;
    private $isActive;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getAvailabilityId(){
        return $this->availabilityId;
    }

    public function setAvailabilityId($availabilityId){
        $this->availabilityId = $availabilityId;
    }

    public function setPetId($petId){
        $this->petId = $petId;
    }

    public function getPetId(){
        return $this->petId;
    }

    public function setIsActive($isActive){
        $this->isActive = $isActive;
    }

    public function getIsActive(){
        return $this->isActive;
    }
    
}


?>