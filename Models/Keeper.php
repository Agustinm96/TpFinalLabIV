<?php

namespace Models;

use Models\User;

class Keeper extends User{
    private $idKeeper; //auto_increment
    private $petSizeToKeep; //small, medium or big
    private $isAvailable; //boolean, falta CALENDARIO??

    public function getIdKeeper(){
        return $this->idKeeper;
    }

    public function setIdKeeper($idKeeper){
        $this->idKeeper = $idKeeper;
    }

    public function getPetSizeToKeep(){
        return $this->petSizeToKeep;
    }

    public function setPetSizeToKeep($petSizeToKeep){
        $this->petSizeToKeep = $petSizeToKeep;
    }

    public function getIsAvailable(){
        return $this->isAvailable;
    }

    public function setIsAvailable($isAvailable){
        $this->isAvailable = $isAvailable;
    }
}

?>