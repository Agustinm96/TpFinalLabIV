<?php
namespace DAO;


use \Exception as Exception;
use Models\User as User;
use Models\Chat as Chat;
use Models\ChatMessage as ChatMessage;
use DAO\Connection as Connection;
use DAO\UserDAO as UserDAO;

class ChatMessageDAO{

    private $connection;
    private $tableName = "chatMessage";
    private $chatMessageArray = array();
    private $chatDAO;

    public function __construct()
    {
        $this->connection = new Connection();
        $this->chatDAO = new ChatDAO();
    }

    public function Add(ChatMessage $newChat)
    {
        try
        {
            $query = "INSERT INTO ".$this->tableName." (id_Chat,userName,dataTime,msg)
             VALUES (:id_Chat, :userName, :dataTime, :msg)";
            $parameters["id_Chat"] = $newChat->getId_Chat()->getId_Chat();
            $parameters["userName"] = $newChat->getUserName();
            $parameters["dataTime"] = $newChat->getDataTime();
            $parameters["msg"] = $newChat->getMsg();
            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
            
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function checkChat($id)
    {
        $query = "SELECT * FROM '$this->tableName' 
        WHERE $id = '$this->tableName.id_Chat";

          try{
            $this->connection = Connection::getInstance();
            $contentArray = $this->connection->Execute($query);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($contentArray)){
          return true;
    }else{
        return null;

    }
    }
    
    public function GetById_Chat($id)
    {
        $query = "SELECT * FROM chatMessage
        WHERE $id = chatMessage.id_Chat
        ORDER BY chatMessage.dataTime";
        
        try{
            $this->connection = Connection::getInstance();
            $contentArray = $this->connection->Execute($query);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($contentArray)){
            foreach($contentArray as $content)
             {
            $chatMsg = new ChatMessage();
            $chat = $this->chatDAO->GetById_Chat($content['id_Chat']);
            $chatMsg->setId_Chat($chat);
            $chatMsg->setId_ChatMessage($content['id_ChatMessage']);
            $chatMsg->setUserName($content['userName']);
            $chatMsg->setDataTime($content['dataTime']);
            $chatMsg->setMsg($content['msg']);
             array_push($this->chatMessageArray, $chatMsg);
       
         }
         //var_dump($this->chatMessageArray);
         return $this->chatMessageArray;
    }else{
        return null;
    }

}

}