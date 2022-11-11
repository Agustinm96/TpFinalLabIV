<?php
namespace DAO;
use Models\PetType as PetType;
use \Exception as Exception;
use DAO\Connection as Connection;

class PetTypeDAO{
    private $petTypeList = array();
    private $connection;
    private $tableName = "petType";

    public function __construct()
    {
        $this->connection = new Connection();
    }

    function GetByPetTypeId($petTypeId)
    {
        $query = "SELECT * FROM petType WHERE petType.id_PetType ='$petTypeId'";
        
        try{
            $this->connection = Connection::getInstance();
            $content = $this->connection->ExecuteSingleResponse($query);
            //var_dump($contentDog); //ANDA
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($content)){
            $petType = new PetType();
            $petType->setPetTypeId($content["id_PetType"]);
            $petType->setPetTypeName($content["petTypeName"]);
            return $petType;

    }else{
        return "ERROR";
    }



}

/*function GetAllPetType()
{
} */ // futura funcion para ver todos lospetType
}
?>