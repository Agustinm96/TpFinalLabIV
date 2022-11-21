<?php
namespace Controllers;

use DAO\ChatDAO as ChatDAO;
use DAO\keeperDAO as keeperDAO;
use MODELS\User as User;

Class ChatController{
    private $userController;
    private $keeperDAO;
    private $chatDAO;

    public function __construct()

    {
        $this->chatDAO = new ChatDAO();
        $this->keeperDAO = new KeeperDAO();
        $this->userController = new UserController();

    }


    public function ShowChatView($message = ""){
        require_once(VIEWS_PATH . "validate-session.php");
        if($_SESSION["loggedUser"]->getUserType()->getId()==1){
        $chatList = $this->chatDAO->GetById_User($_SESSION["loggedUser"]->getId(),"id_Owner");
        }
        if($_SESSION["loggedUser"]->getUserType()->getId()==2){
            $chatList = $this->chatDAO->GetById_User($_SESSION["loggedUser"]->getId(),"id_Keeper");
            }
        if($chatList==NULL){
            if($message == ""){
        $message ="NO DISPONE DE CHATS ACTIVOS";
            }
        }else{
            if($message == ""){
            $message = "Seleccione un chat para comenzar";  
        }
        }
        require_once(VIEWS_PATH . "chat-list.php");
      }

      public function getAllKeepers(){
         require_once(VIEWS_PATH . "validate-session.php");
         $keeperList = $this->keeperDAO->GetAll();
         
         require_once(VIEWS_PATH . "chat-list.php");
      }

      public function lookForKeeper($searchParameter){
         require_once(VIEWS_PATH . "validate-session.php");
         $result = $this->userController->userDAO->getByNameOrLastName($searchParameter);
         if($_SESSION["loggedUser"]->getUserType()->getId()==1){
            $chatList = $this->chatDAO->GetById_User($_SESSION["loggedUser"]->getId(),"id_Owner");
            }
         require_once(VIEWS_PATH . "chat-list.php");
      }



      public function Add($id_Keeper){
      $newchat = new Chat();
      $userAux = new User();
      $userAux->setId_user($id_Keeper); // ID keeper
      $newchat->setId_Keeper($userAux);
      $userAux->setId_user($_SESSION["loggedUser"]->getId());
      $newchat->setId_Owner($userAux); // ID OWNER que esta logeado
      $this->chatDAO->Add($newchat);
      }


      public function NewChat($id_nonloggedUser){
      require_once(VIEWS_PATH . "validate-session.php");
      $flag = 0;
      $chatList = $this->chatDAO->GetById_User($_SESSION["loggedUser"]->getId(),"id_Keeper");
      foreach($chatList as $chat){
        if($chat->getId_Keeper()->getId()==$id_nonloggedUser){
        $flag =1;
        }
      }
      if($flag==1){
      $this->ShowChatView("Ya posees un chat iniciado con este usuario");
      }else{
      $this->add($id_nonloggedUser);
      $this->ShowChatView();
      }
      }
}

?>