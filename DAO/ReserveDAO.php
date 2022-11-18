<?php

namespace DAO;

use Models\Keeper;
use Models\Availability;
use Models\Reserve;
use Models\Pet;

class ReserveDAO{
    private $tableName = 'Reserve';
    private $petDAO;
    private $availabilityDAO;

    public function __construct(){
        $this->petDAO = new PetDAO();
        $this->availabilityDAO = new AvailabilityDAO();
    }

    public function Add(Reserve $reserve) {
        $sql = "INSERT INTO Reserve (id_reserve, id_availability, id_pet, isActive) VALUES (:id_reserve, :id_availability, :id_pet, :isActive)";

        //autoincremental Id in db
        $parameters['id_reserve'] = 0;
        $parameters['id_availability'] =  $reserve->getAvailability()->getId();
        $parameters['id_pet'] = $reserve->getPet()->getId_Pet();
        $parameters['isActive'] = $reserve->getIsActive();

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

    public  function GetAll2() {
        $sql = "SELECT * FROM Reserve r 
        join pet p on r.id_pet=p.id_Pet 
        join User u on p.id_user=u.id_user
        join Availability a on r.id_availability=a.id_availability
        ORDER BY a.`dateSpecific`,u.id_user;";
    
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
            $availability = $this->availabilityDAO->GetById($p["id_availability"]);
            $pet = $this->petDAO->GetById($p["id_pet"]);

            $reserve = new Reserve();
            $reserve->setId($p['id_reserve']);
            $reserve->setAvailability($availability);
            $reserve->setPet($pet);
            $reserve->setIsActive($p['isActive']);
            
            return $reserve;
        }, $value);

        return count($resp) > 1 ? $resp : $resp['0'];
    }

    public function GetDoneReserveArrayByAvailabilityId($availabilityId){
        $reserves=$this->GetAll();
        $arrayToReturn = array();

        if(is_array($reserves)){
            foreach($reserves as $reserve){
                    if($reserve->getAvailability()->getId() === $availabilityId && $reserve->getIsActive() == 0){
                        array_push($arrayToReturn, $reserve); 
                        }
                    }
        }elseif($reserves){
            if($reserves->getAvailability()->getId() === $availabilityId && $reserves->getIsActive()==0)
            array_push($arrayToReturn, $reserves); 
        }
    
        $arrFinal = array_unique($arrayToReturn,SORT_REGULAR);

        return $arrFinal;
    }


        public function Modify(Reserve $reserve) {
            $var = $this->tableName;
            
        try
        {
        $query = "UPDATE $var SET isActive='".$reserve->getIsActive()."'
        WHERE $var.id_reserve='".$reserve->getId()."';";
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