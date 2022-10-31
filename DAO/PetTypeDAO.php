<?php
namespace DAO;
use Models\PetType as PetType;

class PetTypeDAO{
    private $petTypeList = array();
    private $fileName = ROOT."Data/petTypes.json";

    function Add(PetType $petType)
    {
        $this->RetrieveData();

        $petType->setPetTypeId($this->GetNextId());

        array_push($this->petTypeList, $petType);

        $this->SaveData();
    }


    function GetAll()
    {
        $this->petTypeList = $this->RetrieveData();

        return $this->petTypeList;
    }

    function GetById($Id)
    {
        // var_dump($Id);// anda
        $this->RetrieveData();
        if($Id==0||$Id==1||$Id==2){
        $petTypeAux = new PetType();
        foreach($this->petTypeList as $petType){
            if($petType->getPetTypeId() == $Id){
                $petTypeAux = $petType;
            }
        }
        // var_dump($petTypeAux); anda
        return $petTypeAux;
    }else{
        echo("ERROR");
    }
    }

    function Remove($Id)
    {
        $this->petTypeList  = $this->RetrieveData();

        $this->petTypeList = array_filter($this->petTypeList, function($petType) use($Id){
            return $petType->getPetTypeId() != $Id;
        });

        $this->SaveData($this->petTypeList);
    }

    public function RetrieveData()
    {
         $this->petTypeList = array();

         if(file_exists($this->fileName))
         {
             $jsonToDecode = file_get_contents($this->fileName);

             $contentArray = ($jsonToDecode) ? json_decode($jsonToDecode, true) : array();
             
             foreach($contentArray as $content)
             {
                 $petType = new PetType();
                 $petType->setPetTypeId($content["petTypeId"]);
                 $petType->setPetTypeName($content["petTypeName"]);
                 array_push($this->petTypeList, $petType);
             }
         }
         // var_dump( $this->petTypeList); //anda
    }


    private function SaveData()
    {
        $arrayToEncode = array();

        foreach($this->petTypeList as $petType)
        {
            $valuesArray = array();
            $valuesArray["petTypeId"] = $petType->getPetTypeId();
            $valuesArray["petTypeName"] = $petType->getPetTypeName();
            array_push($arrayToEncode, $valuesArray);
        }

        $fileContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

        file_put_contents($this->fileName, $fileContent);
    }
    private function GetNextId()
    {
        $id = 0;

        foreach($this->petTypeList as $petType)
        {
            $id = ($petType->getPetTypeId() > $id) ? $petType->getPetTypeId() : $id;
        }

        return $id + 1;
    }

}


?>