<?php

namespace DAO;

use DAO\IUserTypeDAO;
use Models\UserType;
use DAO\Connection as Connection;

class UserTypeDAO implements IUserTypeDAO
{
    private $userTypeList = array();
    private $fileName;
    private $connection;
    private $tableName = "UserType";

    function Add(UserType $userType)
    {
        $sql = "INSERT INTO UserType (id_userType, typeName) VALUES (:id_userType, :typeName)";

        //autoincremental Id in db
        $parameters['id_userType'] = 0;
        $parameters['typeName'] = $userType->getName(); 

        try {
            $this->connection = Connection::getInstance();
            return $this->connection->ExecuteNonQuery($sql, $parameters);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    function GetAll()
    {
        $sql = "SELECT * FROM UserType";
    
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
            $userType = new UserType();
            $userType->setId($p['id_userType']);
            $userType->setName($p['typeName']);
            
            return $userType;
        }, $value);

        return count($resp) > 1 ? $resp : $resp['0'];
    }


    function GetById($id)
    {
        $sqlSelectId = "select * from UserType where id_userType = '".$id."';";
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

    function Remove($id)
    {
        $sql="DELETE FROM UserType WHERE UserType.id_UserType=:id";
        $values['id_UserType'] = $id;

        try{
            $this->connection= Connection::getInstance();
            return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }


}