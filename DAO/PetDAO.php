<?php
namespace DAO;

use Models\Dog as Dog;
use Models\Pet as pet;

class PetDAO{
    private $petList = array();
    private $fileName = ROOT."Data/pets.json";

    function GetAll()
    {
        $this->petlist = $this->RetrieveData();

        return $this->petList;
    }

    function GetByUserName($USERNAME)
    {
        $this->petList  = $this->RetrieveData();
        $pets = array_filter($this->petList, function($pet) use($USERNAME){
            return $pet->getUserName() == $USERNAME;
        });

        $pets = array_values($pets); //Reorderding array

        return (count($pets) > 0) ? $pets : null;

    }


    function GetById($ID)
    {
        $this->petList  = $this->RetrieveData();

        $pets = array_filter($this->petList, function($pet) use($ID){
            return $pet->getIDPET() == $ID;
        });

        $pets = array_values($pets); //Reorderding array

        return (count($pets) > 0) ? $pets[0] : null;
    }

    function Remove($ID)
    {
        $this->petList  = $this->RetrieveData();

        $this->petList = array_filter($this->petList, function($pet) use($ID){
            return $pet->getIDPET() != $ID;
        });

        $this->SaveData($this->petList);
    }

    public function RetrieveData()
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
               // if($content->getPetType()=="dog"){
                 $dog = new Dog();
                 $dog->setIDPET($content["IDPET"]);
                 $dog->setPetType($content["petType"]);
                 $dog->setName($content["name"]);
                 $dog->setBirthDate($content["birthDate"]);
                 $dog->setObservation($content["observation"]);
                 $dog->setPicture($content["picture"]); //PREGUNTAR
                 $dog->setVaccinationPlan($content["vaccinationPlan"]);
                 $dog->setRace($content["race"]);
                 $dog->setSize($content["size"]);
                 $dog->setVideoPET($content["videoPet"]);
                 $dog->setUserName($content["userName"]);
                 array_push($this->petList, $dog);
              //  }
             }
         }
         return $this->petList;
    }

    public function SaveData($petList)
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
            $valuesArray["size"] = $dog->getSize();
            $valuesArray["videoPet"] = $dog->getVideoPET();
            $valuesArray["userName"] = $dog->getUserName();
            array_push($arrayToEncode, $valuesArray);
            }
        }

        $fileContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

        file_put_contents($this->fileName, $fileContent);
    }

    public function GetNextId()
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