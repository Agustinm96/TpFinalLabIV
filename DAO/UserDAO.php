<?php

namespace DAO;

use DAO\IUserDAO;
use Models\User;
use Models\UserType;
use DAO\UserTypeDAO;
use DAO\Connection as Connection;

class UserDAO implements IUserDAO
{
    private $userList = array();
    private $fileName;
    private $connection;
    private $tableName = "User";

    public function __construct(){
        $this->userTypeDAO = new UserTypeDAO();
    }

    function Add(User $user)
    {
        $sql = "INSERT INTO User (id_user, firstName, lastName, dni, email, phoneNumber, id_userType, userName, pass) VALUES (:id_user, :firstName, :lastName, :dni, :email, :phoneNumber, :id_userType, :userName, :pass)";

        //autoincremental Id in db
        $parameters['id_user'] = 0;
        $parameters['firstName'] = $user->getFirstName();
        $parameters['lastName'] = $user->getLastName();
        $parameters['dni'] = $user->getDni();
        $parameters['email'] = $user->getEmail();
        $parameters['phoneNumber'] = $user->getPhoneNumber();
        $parameters['id_userType'] = $user->getUserType()->getId();
        $parameters['userName'] = $user->getUsername();
        $parameters['pass'] = $user->getPassword();

        try {
            $this->connection = Connection::getInstance();
            return $this->connection->ExecuteNonQuery($sql, $parameters, true);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

    function GetAll()
    {
        $sql = "SELECT * FROM User";
    
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
            $userType = $this->userTypeDAO->GetById($p['id_userType']);
            $user = new User();
            $user->setId($p['id_user']);
            $user->setFirstName($p['firstName']);
            $user->setLastName($p['lastName']);
            $user->setDni($p['dni']);
            $user->setEmail($p['email']);
            $user->setPhoneNumber($p['phoneNumber']);
            $user->setUserType($userType);
            $user->setUserName($p['userName']);
            $user->setPassword($p['pass']);

            return $user;
        }, $value);

        return count($resp) > 1 ? $resp : $resp['0'];
    }

    function GetByDNI($dni)
    {
        $sqlSelectId = "select * from User where dni = '".$dni."';";
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

    function Remove($id_user)
    {
        $sql="DELETE FROM User WHERE User.id_user=:id_user";
        $values['id_user'] = $id_user;

        try{
            $this->connection= Connection::getInstance();
            return $this->connection->ExecuteNonQuery($sql,$values);
        }catch(\PDOException $ex){
            throw $ex;
        }
    }



    public function GetByUserName($userName)
    {
        $sqlSelectId = "select * from User where userName = '".$userName."';";
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

    function GetById($id)
    {
        $sqlSelectId = "select * from User where id_user = '".$id."';";
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

    public function GetByEmail($email)
    {
        $sqlSelectId = "select * from User where email = '".$email."';";
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

    public function Modify(User $user)
    {
        
    }

    public function getByNameOrLastName($parameters) {
        $query = "SELECT * FROM User WHERE firstName LIKE '%".$parameters."%' 
        || lastName LIKE '%".$parameters."%'
        and id_userType = '2';";
        try{
            $this->connection = Connection::getInstance();
            $result = $this->connection->Execute($query);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($result)){
            return $this->mapear($result);
        }else{
            return null;
        }
    }

    
}
