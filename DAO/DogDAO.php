<?php
namespace DAO;

use Models\Dog as Dog;

class DogDAO{
    private $petList = array();
    private $fileName = ROOT."Data/pets.json";
    private $petDAO;

    public function __construct()
    {
        $this->$petDAO = new PetDAO();
    }

    function Add(dog $dog)
    {
        $this->$petList = $this->petDAO->RetrieveData();

        $dog->setId($this->petDAO->GetNextId());

        array_push($this->petList, $pet);

        $this->petDAO->SaveData($petList);
    }

}
?>