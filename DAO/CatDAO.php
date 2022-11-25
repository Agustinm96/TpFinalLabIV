<?php
namespace DAO;


use \Exception as Exception;
use Models\Cat as Cat;
use Models\PetType as PetType;
use Models\User as User;
use DAO\PetDAO as PetDAO;
use DAO\Connection as Connection;
use CONTROLLERS\PetController as PetController;

class CatDAO{
    private $petDAO;
    private $connection;
    private $tableName = "cat";

    public function __construct()
    {
        $this->petDAO = new PetDAO();
        $this->connection = new Connection();
    }

    public function Add(Cat $cat)
    {
        try
        {
            $query = "INSERT INTO ".$this->tableName." (race,id_Pet,vaccinationPlan)
             VALUES (:race, :id_Pet , :vaccinationPlan)";
            $id = $this->petDAO->Add($cat->getName(),$cat->getBirthDate(),
            $cat->getObservation(),$cat->getPetType()->getPetTypeId(),$cat->getId_User()->GetId());
            $parameters["race"] = $cat->getRace();
            $parameters["vaccinationPlan"] = $cat->getVaccinationPlan();
            $parameters["id_Pet"] = $id;

            $this->connection = Connection::GetInstance();

            $var=$this->connection->ExecuteNonQuery($query, $parameters);
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }


    public function modify($name, $birthDate, $observation,$race, $id_Pet){
        $var = $this->tableName;
        $this->petDAO->Modify($name, $birthDate, $observation, $id_Pet);
        try
        {
            $query = "UPDATE $var SET 
                                     
                                    race='$race'
            WHERE $var.id_Pet='$id_Pet';";
            $this->connection = Connection::GetInstance();
            $this->connection->execute($query);
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