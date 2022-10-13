<?php

namespace DAO;

use DAO\IUserTypeDAO;
use Models\UserType;

class UserTypeDAO implements IUserTypeDAO
{
    private $userTypeList = array();
    private $fileName = ROOT . "Data/userTypes.json";

    function Add(UserType $userType)
    {
        $this->RetrieveData();

        $userType->setId($this->GetNextId());

        array_push($this->userTypeList, $userType);

        $this->SaveData();
    }

    function GetAll()
    {
        $this->RetrieveData();

        return $this->userTypeList;
    }

    function GetById($id)
    {
        $this->RetrieveData();

        $userTypes = array_filter($this->userTypeList, function ($userType) use ($id) {
            return $userType->getId() == $id;
        });

        $userTypes = array_values($userTypes); //Reorderding array

        return (count($userTypes) > 0) ? $userTypes[0] : null;
    }

    function Remove($id)
    {
        $this->RetrieveData();

        $this->userTypeList = array_filter($this->userTypeList, function ($userType) use ($id) {
            return $userType->getId() != $id;
        });

        $this->SaveData();
    }

    private function RetrieveData()
    {
        $this->userTypeList = array();

        if (file_exists($this->fileName)) {
            $jsonToDecode = file_get_contents($this->fileName);

            $contentArray = ($jsonToDecode) ? json_decode($jsonToDecode, true) : array();

            foreach ($contentArray as $content) {
                $userType = new UserType();
                $userType->setId($content["id"]);
                $userType->setName($content["name"]);
                $userType->setDescription($content["description"]);

                array_push($this->userTypeList, $userType);
            }
        }
    }

    private function SaveData()
    {
        $arrayToEncode = array();

        foreach ($this->userTypeList as $userType) {
            $valuesArray = array();
            $valuesArray["id"] = $userType->getId();
            $valuesArray["name"] = $userType->getName();
            $valuesArray["description"] = $userType->getDescription();
            array_push($arrayToEncode, $valuesArray);
        }

        $fileContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

        file_put_contents($this->fileName, $fileContent);
    }

    private function GetNextId()
    {
        $id = 0;

        foreach ($this->userTypeList as $userType) {
            $id = ($userType->getId() > $id) ? $userType->getId() : $id;
        }

        return $id + 1;
    }

}
