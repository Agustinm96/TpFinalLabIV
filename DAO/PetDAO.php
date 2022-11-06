<?php
namespace DAO;


use \Exception as Exception;
use Models\Pet as Pet;
use Models\Dog as Dog;
use Models\Cat as Cat;
use Models\PetType as PetType;
use Models\User as User;
use DAO\Connection as Connection;

class PetDAO{
    private $petList = array();
    private $fileName = ROOT."Data/pets.json";
    private $connection;
    private $tableName = "pet";
    

    public function __construct()
    {
        $this->connection = new Connection();
    }

    public function Add($namePet,$birthDate,$observation,$id_PetType,$id_user)
    {
        try
        {
            $query = "INSERT INTO ".$this->tableName." (namePet, birthDate, observation,id_PetType,id_user)
             VALUES (:namePet, :birthDate, :observation, :id_PetType, :id_user);";
            
            $parameters["namePet"] = $namePet;
            $parameters["birthDate"] = $birthDate;
            $parameters["observation"] = $observation;
            $parameters["id_PetType"] = $id_PetType; //DEBERIA PASAR SOLO ID;
            $parameters["id_user"] = $id_user; //DEBERIA PASAR SOLO ID;
           
            $this->connection = Connection::GetInstance();

           $id = $this->connection->ExecuteNonQuery($query, $parameters,true);
           var_dump($id);
           return $id;
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function uploadVideo($filename,$id_Pet){
        $var = $this->tableName;
        try
        {
            $query = "UPDATE $var SET videoPet='$filename'
            WHERE $var.id_Pet=$id_Pet";
            $parameters["videoPet"] = $filename;
            $this->connection = Connection::GetInstance();
            $this->connection->prepare($query);
            $this->connection->Execute($query,$parameters);
            //$this->connection->ExecuteNonQuery($query,$parameters);
        }
        catch(Exception $ex)
        {
            throw $ex;
        }

}

public function uploadPicture($filename,$id_Pet){
    $var = $this->tableName;
    try
    {
        $query = "UPDATE $var SET picture='$filename'
        WHERE $var.id_Pet=$id_Pet";
        $this->connection = Connection::GetInstance();
        $this->connection->execute($query);
    }
    catch(Exception $ex)
    {
        throw $ex;
    }

}
    
    public function GetById_User($id_user){
    //var_dump($id_user);
       $query = "SELECT * FROM pet WHERE $id_user=pet.id_user AND pet.isActive = 1";
       try{
        $this->connection = Connection::getInstance();
        $contentArray = $this->connection->Execute($query);
      //var_dump($contentArray); //ANDA
    }catch(\PDOException $ex){
        throw $ex;
    }
      $list = array();
    if(!empty($contentArray)){
        foreach($contentArray as $content)
         {
           if($content["id_PetType"]=="1"){
            $pet = $this->SetDogToReceive($content);
           }
            if($content["id_PetType"]=="2"){
                $pet = $this->SetCatToReceive($content);
         }
         if($content["id_PetType"]=="3"){
            $pet = $this->SetGuineaPigToReceive($content);
     }
         array_push($list, $pet);
     }
        return $list; //?? no se si retornar la lista;
    }else{
        return null;
    }
    }



    public function GetAll(){

        $query = "SELECT * FROM pet WHERE pet.isActive = 1";
        
        try{
            $this->connection = Connection::getInstance();
            $contentArray = $this->connection->Execute($query);
        }catch(\PDOException $ex){
            throw $ex;
        }
        
        if(!empty($contentArray)){
            foreach($contentArray as $content)
             {
               if($content["id_PetType"]=="1"){
                $pet = $this->SetDogToReceive($content);
               }
                if($content["id_PetType"]=="2"){
                    $pet = $this->SetCatToReceive($content);
             }
             if($content["id_PetType"]=="3"){
                $pet = $this->SetGuineaPigToReceive($content);
         }
             array_push($this->petList, $pet);
         }
            return $this->petList; //?? no se si retornar la lista;
        }else{
            return null;
        }
    }
    
    public function SetDogToReceive($content){
        $id = $content['id_Pet'];
        $query = "SELECT * FROM dog WHERE $id = dog.id_Pet";
        
        try{
            $this->connection = Connection::getInstance();
            $contentDog = $this->connection->ExecuteSingleResponse($query);
            //var_dump($contentDog); //ANDA
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($contentDog)){
        $dog = new Dog();
        $petType = new PetType();
        $petType->setPetTypeId($content["id_PetType"]);
        $user = new User();
        $user->setId($content["id_user"]);
        // var_dump($content["petType"]); 
        // var_dump($petType);
        $dog->setIsActive($content["isActive"]);
        $dog->setId_Pet($content["id_Pet"]); //MODIFICAR
        $dog->setPetType($petType);
        $dog->setName($content["namePet"]);
        $dog->setBirthDate($content["birthDate"]);
        $dog->setObservation($content["observation"]);
        $dog->setPicture($content["picture"]); //PREGUNTAR
        $dog->setVideoPet($content["videoPet"]);
        $dog->setId_User($user); 
        $dog->setVaccinationPlan($contentDog['vaccinationPlan']);
        $dog->setRace($contentDog["race"]);
        $dog->setSize($contentDog["size"]);
        return $dog;
        }else{
            return "ERROR";
        }
    }

    public function SetCatToReceive($content){
        $id = $content['id_Pet'];
        $query = "SELECT * FROM cat WHERE $id = cat.id_Pet";
        
        try{
            $this->connection = Connection::getInstance();
            $contentCatArray = $this->connection->Execute($query);
            //var_dump($contentCatArray);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($contentCatArray)){
        $cat = new Cat();
        $petType = new PetType();
        $petType->setPetTypeId($content["id_PetType"]);
        $user = new User();
        $user->setId($content["id_user"]);
        // var_dump($content["petType"]); 
        // var_dump($petType);
        $cat->setIsActive($content["isActive"]);
        $cat->setId_Pet($content["id_Pet"]);
        $cat->setPetType($petType);
        $cat->setName($content["namePet"]);
        $cat->setBirthDate($content["birthDate"]);
        $cat->setObservation($content["observation"]);
        $cat->setPicture($content["picture"]); //PREGUNTAR
        $cat->setVideoPet($content["videoPet"]);
        $cat->setId_User($user);
        foreach($contentCatArray as $contentCat){
        $cat->setVaccinationPlan($contentCat["vaccinationPlan"]);
        $cat->setRace($contentCat["race"]);
        }
        return $cat;
        }else{
            return "ERROR";
        }
    }

    function validateDate($birthDate)
    {
        $checkDate = date("Y-m-d",strtotime($birthDate.' + 3 months '));
        if($checkDate>=date("Y-m-d")){
         return false;
        }else{
            return true;
        }
    }

}

?>