<?php

namespace DAO;

use Models\Keeper;
use Models\Availability;
use Models\Reserve;

class ReserveDAO{
    private $tableName = 'Reserve';

    public function __construct(){
        $this->connection = new Connection();
    }

    public function Add(Reserve $reserve) {
        $sql = "INSERT INTO Reserve (id_reserve, id_availability, id_pet) VALUES (:id_reserve, :id_availability, :id_pet)";

        //autoincremental Id in db
        $parameters['id_reserve'] = 0;
        $parameters['id_availability'] =  $reserve->getAvailabilityId();
        $parameters['id_pet'] = $reserve->getPetId();

        try {
            $this->connection = Connection::getInstance();
            return $this->connection->ExecuteNonQuery($sql, $parameters, true);
        } catch (\PDOException $ex) {
            throw $ex;
        }
        
    }

    public function Remove($id) {
        $sql="DELETE FROM Reserve WHERE Reserve.id_reserve=:id_reserve";
            $values['id_reserve'] = $id;
    
            try{
                $this->connection= Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql,$values);
            }catch(\PDOException $ex){
                throw $ex;
            }
    }

    public function RemoveByAvailabilityId($id_availability) {
        $sql="DELETE FROM Reserve WHERE Reserve.id_availability=:id_availability";
            $values['id_availability'] = $id_availability;
    
            try{
                $this->connection= Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql,$values);
            }catch(\PDOException $ex){
                throw $ex;
            }
    }

    public  function GetAll() {
        $sql = "SELECT * FROM Reserve";
    
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
        $sqlSelectId = "select * from Reserve where id_reserve = '".$id."';";
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
            $reserve = new Reserve();
            $reserve->setId($p['id_reserve']);
            $reserve->setAvailabilityId($p["id_availability"]);
            $reserve->setPetId($p['id_pet']);
            
            return $reserve;
        }, $value);

        return count($resp) > 1 ? $resp : $resp['0'];
    }

    public function GetReserveArrayByAvailabilityId($availabilityId){
        $reserves=$this->GetAll();
        $arrayToReturn = array();

        if(is_array($reserves)){
            foreach($reserves as $reserve){
                    if($reserve->getAvailabilityId() === $availabilityId){
                        array_push($arrayToReturn, $reserve); 
                        }
                    }
        }elseif($reserves){ //porque lo devuelve como objeto
            array_push($arrayToReturn, $reserves); 
        }
    
        $arrFinal = array_unique($arrayToReturn,SORT_REGULAR);

        return $arrFinal;
    }


        public function Modify(Reserve $reserve) {
           
        }

    }

    


?>