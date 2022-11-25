<?php
namespace DAO;


use \Exception as Exception;
use Models\User as User;
use Models\Chat as Chat;
use DAO\Connection as Connection;
use DAO\UserDAO as UserDAO;
class ChatDAO{
    private $connection;
    private $tableName = "chat";
    private $chatList = array();
    private $userDAO;

    public function __construct()
    {
        $this->connection = new Connection();
        $this->userDAO = new UserDAO();
    }

    public function Add(Chat $newChat)
    {
        try
        {
            $query = "INSERT INTO ".$this->tableName." (id_Owner,id_Keeper)
             VALUES (:id_Owner, :id_Keeper)";
            $parameters["id_Owner"] = $newChat->getId_Owner()->getId();
            //var_dump($parameters["id_Owner"]);
            $parameters["id_Keeper"] = $newChat->getId_Keeper()->getId();
            //var_dump($parameters["id_Keeper"]);
            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
            
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }
 
    public function clearList(){
        $this->chatList = array();
    }
    

    public function GetById_User($id,$parameter)
    {
        $query = "SELECT * FROM chat WHERE $id = chat.$parameter";
        $this->clearList();
        try{
            $this->connection = Connection::getInstance();
            $contentArray = $this->connection->Execute($query);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($contentArray)){
            foreach($contentArray as $content)
             {
            $chat = new Chat();
            $userOwner = $this->userDAO->GetById($content['id_Owner']);
            $userKeeper = $this->userDAO->GetById($content['id_Keeper']);
            $chat->setId_Chat($content['id_Chat']);
            $chat->setId_Owner($userOwner);
            $chat->setId_Keeper($userKeeper);
             array_push($this->chatList, $chat);
         }
         return $this->chatList;
    }else{
        return null;
    }

}

public function getById_Chat($id)
{
    $query = "SELECT * FROM chat WHERE $id = chat.id_Chat";
    
    try{
        $this->connection = Connection::getInstance();
        $contentArray = $this->connection->Execute($query);
    }catch(\PDOException $ex){
        throw $ex;
    }
    if(!empty($contentArray)){
        foreach($contentArray as $content)
         {
        $chat = new Chat();
        $userOwner = $this->userDAO->GetById($content['id_Owner']);
        $userKeeper = $this->userDAO->GetById($content['id_Keeper']);
        $chat->setId_Chat($content['id_Chat']);
        $chat->setId_Owner($userOwner);
        $chat->setId_Keeper($userKeeper);
     }
     return $chat;
}else{
    return null;
}

}

}
?>
