<?php
namespace DAO;

use Models\Dog as Dog;
use Models\Cat as Cat;
use Models\Pet as pet;
use Models\PetType as PetType;
use DAO\PetTypeDAO as PetTypeDAO; //consultar;


class PetDAO{
    public $petList = array();
    private $fileName = ROOT."Data/pets.json";
    private $petTypeDAO;

    public function __construct()
    {
        $this->petTypeDAO = new PetTypeDAO();
    }



    public function GetAll()
    {
        $this->petlist = $this->RetrieveData();
       
        return $this->petList;
    }

    public function GetByUserName($USERNAME)
    {
        $this->petList  = $this->RetrieveData();
        $pets = array_filter($this->petList, function($pet) use($USERNAME){
            return $pet->getUserName() == $USERNAME;
        });

        $pets = array_values($pets); //Reorderding array
        // var_dump($pets); anda
       /* if($pets!=null){
            foreach($pets as $pet){
                var_dump($pet->getPetType());
                $petID = $this->petTypeDAO->GetById($pet->getPetType());
                $pet->setPetType();
            }
        } */
        return (count($pets) > 0) ? $pets : null;

    }


    public function GetById($ID)
    {
        $this->petList  = $this->RetrieveData();

        $pets = array_filter($this->petList, function($pet) use($ID){
            return $pet->getIDPET() == $ID;
        });

        $pets = array_values($pets); //Reorderding array

        return (count($pets) > 0) ? $pets[0] : null;
    }

    public function Remove($ID)
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
               if($content["petType"]=="0"){
                $pet = $this->setDogToReceive($content);
               }
                if($content["petType"]=="1"){
                    $pet = $this->setCatToReceive($content);
             }
             if($content["petType"]=="2"){
                $pet = $this->setGuineaPigToReceive($content);
         }
             array_push($this->petList, $pet);
         }
         return $this->petList;
    }
         }
    public function SaveData($petList)
    {
        $arrayToEncode = array();
        foreach($petList as $pet)
        {
           // var_dump($pet->getPetType()->getPetTypeId()); //ANDA
            if($pet->getPetType()->getPetTypeId()==0){
                $valuesArray = $this->setDogToSave($pet);
                array_push($arrayToEncode, $valuesArray);
            }
            if($pet->getPetType()->getPetTypeId()==1){
                $valuesArray = $this->setCatToSave($pet);
                array_push($arrayToEncode, $valuesArray);
            }
            if($pet->getPetType()->getPetTypeId()==2){
                $valuesArray = $this->setGuineaPigToSave($pet);
                array_push($arrayToEncode, $valuesArray);
            }
        }
        // var_dump($arrayToEncode); ANDA
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

    public function setDogToReceive($content){
        $dog = new Dog();
        $petType = new PetType();
        $petType = $this->petTypeDAO->GetById($content["petType"]);
        // var_dump($content["petType"]); anda
        // var_dump($petType); anda
        $dog->setIDPET($content["IDPET"]);
        $dog->setPetType($petType);
        $dog->setName($content["name"]);
        $dog->setBirthDate($content["birthDate"]);
        $dog->setObservation($content["observation"]);
        $dog->setPicture($content["picture"]); //PREGUNTAR
        $dog->setVaccinationPlan($content["vaccinationPlan"]);
        $dog->setRace($content["race"]);
        $dog->setSize($content["size"]);
        $dog->setVideoPET($content["videoPet"]);
        $dog->setUserName($content["userName"]);
        return $dog;
    }
    public function setCatToReceive($content){
        $cat = new Cat();
        $cat->setIDPET($content["IDPET"]);
        $cat->setPetType($this->petTypeDAO->GetById($content["petType"]));
        $cat->setName($content["name"]);
        $cat->setBirthDate($content["birthDate"]);
        $cat->setObservation($content["observation"]);
        $cat->setPicture($content["picture"]); //PREGUNTAR
        $cat->setVaccinationPlan($content["vaccinationPlan"]);
        $cat->setRace($content["race"]);
        $cat->setVideoPET($content["videoPet"]);
        $cat->setUserName($content["userName"]);
        return $cat;
    }

    public function setDogToSave(Dog $dog){
        $valuesArray = array();
        $valuesArray["IDPET"] = $dog->getIDPET();
        $valuesArray["petType"] = $dog->getPetType()->getPetTypeId();
        $valuesArray["name"] = $dog->getName();
        $valuesArray["observation"] = $dog->getObservation();
        $valuesArray["birthDate"] = $dog->getBirthDate();
        $valuesArray["picture"] = $dog->getPicture();
        $valuesArray["vaccinationPlan"] = $dog->getVaccinationPlan();
        $valuesArray["race"] = $dog->getRace();
        $valuesArray["size"] = $dog->getSize();
        $valuesArray["videoPet"] = $dog->getVideoPET();
        $valuesArray["userName"] = $dog->getUserName();
        return $valuesArray;
    }
    
    public function setCatToSave(Cat $cat){
        $valuesArray = array();
        $valuesArray["IDPET"] = $cat->getIDPET();
        $valuesArray["petType"] = $cat->getPetType()->getPetTypeId();
        $valuesArray["name"] = $cat->getName();
        $valuesArray["observation"] = $cat->getObservation();
        $valuesArray["birthDate"] = $cat->getBirthDate();
        $valuesArray["picture"] = $cat->getPicture();
        $valuesArray["vaccinationPlan"] = $cat->getVaccinationPlan();
        $valuesArray["race"] = $cat->getRace();
        $valuesArray["videoPet"] = $cat->getVideoPET();
        $valuesArray["userName"] = $cat->getUserName();
        return $valuesArray;
    }

}

?>