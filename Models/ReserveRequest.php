<?php

namespace Models;

class ReserveRequest{
    private $id;
    private $availabilityId;
    private $petId;

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

    public function getPetId(){
        return $this->petId;
    }


    public function setPetId($petId){
        $this->petId = $petId;
    }

}


?>