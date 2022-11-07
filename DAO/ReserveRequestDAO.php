<?php

namespace DAO;


use Models\ReserveRequest;


class ReserveRequestDAO{
    private $tableName = "ReserveRequest";

    public function __construct(){
        $this->connection = new Connection();
    }
    

    public function Add($requestReserve) {
        $sql = "INSERT INTO ReserveRequest (id_ReserveRequest, id_availability, id_pet) VALUES (:id_ReserveRequest, :id_availability, :id_pet)";

        //autoincremental Id in db
        $parameters['id_ReserveRequest'] = 0;
        $parameters['id_availability'] =  $requestReserve->getAvailabilityId();
        $parameters['id_pet'] = $requestReserve->getPetId();

        try {
            $this->connection = Connection::getInstance();
            return $this->connection->ExecuteNonQuery($sql, $parameters, true);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function Remove($id) {
        $sql="DELETE FROM ReserveRequest WHERE ReserveRequest.id_ReserveRequest=:id_ReserveRequest";
            $values['id_ReserveRequest'] = $id;
    
            try{
                $this->connection= Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql,$values);
            }catch(\PDOException $ex){
                throw $ex;
            }
    }

    public function RemoveByAvailabilityId($id_availability) {
        $sql="DELETE FROM ReserveRequest WHERE ReserveRequest.id_availability=:id_availability";
            $values['id_availability'] = $id_availability;
    
            try{
                $this->connection= Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql,$values);
            }catch(\PDOException $ex){
                throw $ex;
            }
    }

    public  function GetAll() {
        $sql = "SELECT * FROM ReserveRequest";
    
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

    public function GetById($id) {
        $sqlSelectId = "select * from ReserveRequest where id_ReserveRequest = '".$id."';";
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
            $reserveRquest = new ReserveRequest();
            $reserveRquest->setId($p['id_ReserveRequest']);
            $reserveRquest->setAvailabilityId($p["id_availability"]);
            $reserveRquest->setPetId($p['id_pet']);
            
            return $reserveRquest;
        }, $value);

        return count($resp) > 1 ? $resp : $resp['0'];
    }

    
}


?>