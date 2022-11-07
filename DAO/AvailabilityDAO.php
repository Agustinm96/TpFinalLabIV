<?php

namespace DAO;

use Models\Keeper;
use Models\Availability;

class AvailabilityDAO{
    private $tableName = "Availability";
    private $availabilityDAO;
    private $connection;
    private $reserveDAO;
    private $reserveRequestDAO;

    public function __construct(){
        $this->connection = new Connection();
        $this->reserveRequestDAO = new ReserveRequestDAO();
        $this->reserveDAO = new ReserveDAO();
    }

    public function Add($availability) {
        $sql = "INSERT INTO Availability (id_availability, dateSpecific, available, id_Keeper) VALUES (:id_availability, :dateSpecific, :available, :id_Keeper)";

        //autoincremental Id in db
        $parameters['id_availability'] = 0;
        $parameters['dateSpecific'] =  $availability->getDate();
        $parameters['available'] = $availability->getAvailable();
        $parameters['id_Keeper'] = $availability->getIdKeeper();

        try {
            $this->connection = Connection::getInstance();
            return $this->connection->ExecuteNonQuery($sql, $parameters, true);
        } catch (\PDOException $ex) {
            throw $ex;
        }
        
    }

    public function Remove($id_availability) {
        $this->reserveDAO->RemoveByAvailabilityId($id_availability);
        $this->reserveRequestDAO->RemoveByAvailabilityId($id_availability);

        $sql="DELETE FROM Availability WHERE Availability.id_availability=:id_availability";
        $values['id_availability'] = $id_availability;

        try{
            $this->connection= Connection::getInstance();
            return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public  function GetAll() {
        $sql = "SELECT * FROM Availability";
    
            try{
                $this->connection = Connection::getInstance();
                $result = $this->connection->Execute($sql);
            }catch(\PDOException $ex){
                throw $ex;
            }
            if(!empty($result)){
                return $this->mapear($result);
            }else{
                return false;
            }
    }

    public function GetById($availabilityId) {
        $sqlSelectId = "select * from Availability where id_availability = '".$availabilityId."';";
        try{
            $this->connection = Connection::getInstance();
            $result = $this->connection->Execute($sqlSelectId);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($result)){
            return $this->mapear($result);
        }else{
            return false;
            }
    }

    protected function mapear ($value){

        $value = is_array($value) ? $value : [];
        
        
        $resp = array_map(function($p){
                $availability = new Availability();
                $availability->setId($p['id_availability']);
                $availability->setDate($p['dateSpecific']);
                $availability->setAvailable($p['available']);
                $availability->setIdKeeper($p["id_keeper"]);
            
                return $availability;
            
            
        }, $value);

        return count($resp) > 1 ? $resp : $resp['0'];
    }


        public function GetByIdKeeper($idKeeper){ //arreglo de keepers
           /**/
            $availabilityList = $this->GetAll();
            $finalArray = array();

            foreach($availabilityList as $availability){
                if($availability->getIdKeeper() == $idKeeper){
                    if($availability->getAvailable()==1){
                        array_push($finalArray, $availability);
                    }
                }
            }
            usort($finalArray, $this->object_sorter('id'));

            return $finalArray;
        }

        function object_sorter($clave,$orden=null) {
            return function ($a, $b) use ($clave,$orden) {
                $result=  ($orden=="DESC") ? strnatcmp($b->$clave, $a->$clave) :  strnatcmp($a->$clave, $b->$clave);
                return $result;
            };
        }

        public function Modify(Availability $availability) {
            var_dump($availability);
            $var = $this->tableName;
            //'".$availabilityId."';";
            
        try
        {
        $query = "UPDATE $var SET available='".$availability->getAvailable()."'
        WHERE $var.id_availability='".$availability->getId()."';";
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