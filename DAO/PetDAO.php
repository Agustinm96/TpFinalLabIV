<?php
namespace DAO;

use Models\Dog as Dog;

class PetDAO{
    private $petList = array();
    private $fileName = ROOT."Data/pets.json";

    function GetAll()
    {
        $this->petlist = RetrieveData();

        return $this->petList;
    }

    function GetById($ID)
    {
        $this->RetrieveData();

        $pets = array_filter($this->petList, function($pet) use($ID){
            return $pet->getIDPET() == $$ID;
        });

        $pets = array_values($pets); //Reorderding array

        return (count($pets) > 0) ? $pets[0] : null;
    }

    function Remove($ID)
    {
        $this->RetrieveData();

        $this->petList = array_filter($this->petList, function($pet) use($ID){
            return $pet->getIDPET() != $ID;
        });

        $this->SaveData();
    }

    private function RetrieveData()
    {
         $this->petList = array();

         if(file_exists($this->fileName))
         {
             $jsonToDecode = file_get_contents($this->fileName);

             $contentArray = ($jsonToDecode) ? json_decode($jsonToDecode, true) : array();
             
             foreach($contentArray as $content)
             {
                /// SETEAR APARTE EL CHECKTYPE();
                /// Y PUSHEAR.
                if($content->getPetType()=="dog"){
                 $dog = new Dog();
                 $dog->setIDPET($content["IDPET"]);
                 $dog->setPetType($content["petType"]);
                 $dog->setName($content["name"]);
                 $dog->setBirthDate($content["birthDate"]);
                 $dog->setObservation($content["observation"]);
                 $dog->setPicture($content["picture"]); //PREGUNTAR
                 $dog->setVaccinationPlan($content["vaccinationPlan"]);
                 $dog->setRace($content["race"]);

                 array_push($this->petList, $dog);
                }
             }
         }
         return $petlist;
    }

    private function SaveData($petList)
    {
        $arrayToEncode = array();

        foreach($petList as $pet)
        {
            if($pet->getPetType()=="dog"){
            $dog = new Dog();
            $dog = $pet;
            $valuesArray = array();
            $valuesArray["IDPET"] = $dog->getIDPET();
            $valuesArray["petType"] = $dog->getPetType();
            $valuesArray["name"] = $dog->getName();
            $valuesArray["observation"] = $dog->getObservation();
            $valuesArray["birthDate"] = $dog->getBirthDate();
            $valuesArray["picture"] = $dog->getPicture();
            $valuesArray["vaccinationPlan"] = $dog->getVaccinationPlan();
            $valuesArray["race"] = $dog->getRace();
            array_push($arrayToEncode, $valuesArray);
            }
        }

        $fileContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

        file_put_contents($this->fileName, $fileContent);
    }

    private function GetNextId()
    {
        $id = 0;

        foreach($this->petList as $pet)
        {
            $id = ($pet->getIDPET() > $id) ? $pet->getIDPET() : $id;
        }

        return $id + 1;
    }

}

?>