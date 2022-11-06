<?php
namespace DAO;


use \Exception as Exception;
use Models\Dog as Dog;
use Models\PetType as PetType;
use Models\User as User;
use DAO\PetDAO as PetDAO;
use DAO\Connection as Connection;
use CONTROLLERS\PetController as PetController;

class DogDAO{
    private $petDAO;
    private $connection;
    private $tableName = "dog";

    public function __construct()
    {
        $this->petDAO = new PetDAO();
        $this->connection = new Connection();
    }

    public function Add(Dog $dog)
    {
        try
        {
            $query = "INSERT INTO ".$this->tableName." (size,race,id_Pet,vaccinationPlan)
             VALUES (:size, :race, :id_Pet , :vaccinationPlan)";
            var_dump($dog->getPetType()->getPetTypeId());
            $id = $this->petDAO->Add($dog->getName(),$dog->getBirthDate(),
            $dog->getObservation(),$dog->getPetType()->getPetTypeId(),$dog->getId_User()->GetId());
            var_dump($id);
            $parameters["size"] = $dog->getSize();
            $parameters["race"] = $dog->getRace();
            $parameters["vaccinationPlan"] = $dog->getVaccinationPlan();
            $parameters["id_Pet"] = $id;

            $this->connection = Connection::GetInstance();

            $var=$this->connection->ExecuteNonQuery($query, $parameters);
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function uploadVaccinationPlan($filename,$id_Pet){
        $var = $this->tableName;
        try
        {
            $query = "UPDATE $var SET VaccinationPlan='$filename'
            WHERE $var.id_Pet=$id_Pet";
            $this->connection = Connection::GetInstance();
            $this->connection->execute($query);
        }
        catch(Exception $ex)
        {
            throw $ex;
        }

}

}
?>