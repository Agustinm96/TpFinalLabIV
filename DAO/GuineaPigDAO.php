<?php
namespace DAO;


use \Exception as Exception;
use Models\GuineaPig as GuineaPig;
use Models\PetType as PetType;
use Models\User as User;
use DAO\PetDAO as PetDAO;
use DAO\Connection as Connection;
use CONTROLLERS\PetController as PetController;

class GuineaPigDAO{
    private $petDAO;
    private $connection;
    private $tableName = "guineaPig";

    public function __construct()
    {
        $this->petDAO = new PetDAO();
        $this->connection = new Connection();
    }

    public function Add(GuineaPig $guineaPig)
    {
        try
        {
            $query = "INSERT INTO ".$this->tableName." (heno,id_Pet,gender)
             VALUES (:heno, :id_Pet , :gender)";
            $id = $this->petDAO->Add($guineaPig->getName(),$guineaPig->getBirthDate(),
            $guineaPig->getObservation(),$guineaPig->getPetType()->getPetTypeId(),$guineaPig->getId_User()->GetId());
            $parameters["heno"] = $guineaPig->getHeno();
            $parameters["gender"] = $guineaPig->getGender();
            $parameters["id_Pet"] = $id;

            $this->connection = Connection::GetInstance();

            $var=$this->connection->ExecuteNonQuery($query, $parameters);
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function modify($name, $birthDate, $observation,$heno,$gender, $id_Pet){
        $var = $this->tableName;
        $this->petDAO->Modify($name, $birthDate, $observation, $id_Pet);
        try
        {
            $query = "UPDATE $var SET 
                                     
                                    heno='$heno',
                                    gender='$gender'
            WHERE $var.id_Pet='$id_Pet';";
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