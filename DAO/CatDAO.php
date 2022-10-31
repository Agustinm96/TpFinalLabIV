<?php
namespace DAO;

use Models\Cat as Cat;
use DAO\PetDAO as PetDAO;

class CatDAO{
    private $petList = array();
    private $fileName = ROOT."Data/pets.json";
    private $petDAO;


    public function __construct()
    {
        $this->petDAO = new PetDAO();
        $this->petTypeDAO = new PetTypeDao();
    }

    function Add(Cat $cat)
    {
        $this->petList = $this->petDAO->RetrieveData();
        $cat->setIDPET($this->petDAO->GetNextId());  
        array_push($this->petList, $cat);

        $this->petDAO->SaveData($this->petList);
    }

}
?>