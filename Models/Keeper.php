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
    private $startingDate; 
    private $lastDate;
    private $arrayDays = array();
    private $petsAmount; //how many pets the keeper wants to take care of

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

    public function getPriceToKeep(){
        return $this->priceToKeep;
    }

    public function setPriceToKeep($priceToKeep){
        $this->priceToKeep = $priceToKeep;
    }

    public function getPetsAmount(){
        return $this->petsAmount;
    }

    public function setPetsAmount($petsAmount){
        $this->petsAmount = $petsAmount; 
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