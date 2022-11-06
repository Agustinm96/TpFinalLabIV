<?php
namespace DAO;

use Models\Dog as Dog;
use DAO\PetDAO as PetDAO;

class DogDAO{
    private $petList = array();
    private $fileName = ROOT."Data/pets.json";
    private $petDAO;

    public function __construct()
    {
        $this->petDAO = new PetDAO();
    }

    function Add(dog $dog)
    {
        $this->petList = $this->petDAO->RetrieveData();

        $dog->setIDPET($this->petDAO->GetNextId());

        array_push($this->petList, $dog);

        $this->petDAO->SaveData($this->petList);
    }

}
?>