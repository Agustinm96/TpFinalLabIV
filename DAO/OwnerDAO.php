<?php

namespace DAO;

use Models\Owner;
use Models\User;
use DAO\Connection as Connection;
use DAO\UserDAO as UserDAO;
class OwnerDAO implements IOwnerDAO
{
    private $ownersList = array();
    private $connection;
    private $tableName = "Owner";

    public function __construct(){
        $this->userDAO = new UserDAO();
    }

    public function Add($owner)
    {
        $sql = "INSERT INTO Owner (id_owner, address, id_user) VALUES (:id_owner, :address, :id_user)";

        //autoincremental Id in db
        $parameters['id_owner'] = 0;
        $parameters['address'] = $owner->getAdress();
        $parameters['id_user'] = $owner->getUser()->getId();
        try {
            $this->connection = Connection::getInstance();
            return $this->connection->ExecuteNonQuery($sql, $parameters, true);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    public function Remove($id_user)
    {
        $sql="DELETE FROM Owner WHERE Owner.id_user=:id_user";
        $values['id_user'] = $id_user;

        try{
            $this->connection= Connection::getInstance();
            return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }

    public  function GetAll()
    {
        $sql = "SELECT * FROM Owner";
    
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

    protected function mapear ($value){

        $value = is_array($value) ? $value : [];
        
        $resp = array_map(function($p){
            $user = $this->userDAO->GetById($p['id_user']);
            $owner = new Owner();
            $owner->setIdOwner($p['id_owner']);
            $owner->setAdress($p['address']);
            $owner->setUser($user);
            
            return $owner;
        }, $value);

        return count($resp) > 1 ? $resp : $resp['0'];
    }

    public function GetById($id)
    {
        $sqlSelectId = "select * from Owner where id_owner = '".$id."';";
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


    public function GetByIdUser($idUser)
    {
        $var = $this->tableName;
        $sqlSelectId = "SELECT * FROM $var WHERE id_user = '".$idUser."';";
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

}
