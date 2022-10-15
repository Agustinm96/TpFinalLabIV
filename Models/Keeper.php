<?php

namespace Models;

use Models\User;
use Models\Reserve;

class Keeper{
    private $user;
    private $idKeeper;
    private $adress;
    private $petSizeToKeep = array(); //small, medium or big
    private $priceToKeep;
    private $reserve = array();

    public function getUser(){
        return $this->user;
    }

    public function setUser(User $user){
        $this->user = $user;
    }

    public function getIdKeeper(){
        return $this->idKeeper;
    }

    public function setIdKeeper($idKeeper){
        $this->idKeeper = $idKeeper;
    }

    public function getAdress(){
        return $this->adress;
    }

    public function setAdress($adress){
        $this->adress = $adress;
    }

    public function getPetSizeToKeep(){
        return $this->petSizeToKeep;
    }

    public function setPetSizeToKeep($petSizeToKeep){
        $this->petSizeToKeep = $petSizeToKeep;
    }

    public function getReserve(){
        return $this->reserve;
    }

    public function setReserve(Reserve $reserve){
        $this->reserve = $reserve;
    }

    public function getPriceToKeep(){
        return $this->priceToKeep;
    }

    public function setPriceToKeep($priceToKeep){
        $this->priceToKeep = $priceToKeep;
    }
}

?>