<?php
namespace Controllers;

use DAO\ChatMessageDAO as ChatMessageDAO;
use DAO\ChatDAO as ChatDAO;
use DAO\keeperDAO as keeperDAO;
use MODELS\User as User;
use MODELS\Chat as Chat;
use MODELS\ChatMessage as ChatMessage;

Class ChatMessageController{


    private $chatMessageDAO;
    private $chatDAO;

    public function __construct()

    {
        $this->chatDAO = new ChatDAO();
        $this->chatMessageDAO = new ChatMessageDAO();

    }


    public function ShowChatStarted($id_Chat){

     require_once(VIEWS_PATH . "validate-session.php");
     $chat = $this->chatDAO->getById_Chat($id_Chat);
     $msgList = $this->chatMessageDAO->getById_Chat($id_Chat);
     require_once(VIEWS_PATH . "chat-front.php");
    }

    public function Chating($newMSG,$id_Chat){

    }

    public function AddMSG($newMSG,$id_Chat){
    
            $newChatMsg = new ChatMessage();
            $newChat = new Chat();
            $newChat->setId_chat($id_Chat);
            $username = $_SESSION["loggedUser"]->getFirstName() . " " . $_SESSION["loggedUser"]->getLastName();
            $newChatMsg->setUserName($username);
            $newChatMsg->setDataTime(date('d-m-y h:i:s')); //Setear DATA HOY
            $newChatMsg->setId_Chat($newChat);
            $newChatMsg->setMsg($newMSG);
            $this->chatMessageDAO->Add($newChatMsg);

           $this->ShowChatStarted($id_Chat);
        }


}

?>