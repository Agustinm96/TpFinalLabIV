<?php
namespace Controllers;

use DAO\ChatDAO as ChatDAO;
use DAO\keeperDAO as keeperDAO;
use MODELS\User as User;
use MODELS\Chat as Chat;

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
        require_once(VIEWS_PATH . "chat-list.php");
      }

      public function getAllKeepers(){
         require_once(VIEWS_PATH . "validate-session.php");
         $keeperList = $this->keeperDAO->GetAll();
         
         require_once(VIEWS_PATH . "chat-list.php");
      }

      public function lookForKeeper($searchParameter){
         require_once(VIEWS_PATH . "validate-session.php");
         $result = null;
         $result = $this->userController->userDAO->getByNameOrLastName($searchParameter);
         if($_SESSION["loggedUser"]->getUserType()->getId()==1){
            $chatList = $this->chatDAO->GetById_User($_SESSION["loggedUser"]->getId(),"id_Owner");
            }
         require_once(VIEWS_PATH . "chat-list.php");
      }



      public function Add($id_Keeper){
      $newchat = new Chat();
      $userAux = new User();
      $userAux2 = new User();
      $userAux->setId($id_Keeper); // ID keeper
      $newchat->setId_Keeper($userAux); //seteo el ID del keeper
      $userAux2->setId($_SESSION["loggedUser"]->getId()); //cambio al ID logeado
      $newchat->setId_Owner($userAux2); // ID OWNER que esta logeado
      $this->chatDAO->Add($newchat);
      }


      public function NewChat($id_nonloggedUser){
      require_once(VIEWS_PATH . "validate-session.php");
      $flag = 0;
      $chatList = $this->chatDAO->GetById_User($_SESSION["loggedUser"]->getId(),"id_Owner");
      if($chatList!=null){
      foreach($chatList as $chat){
        if($chat->getId_Keeper()->getId()==$id_nonloggedUser){
        $flag =1;
        }
      }
    }
      if($flag==1){
      $this->ShowChatView("Ya posees un chat iniciado con este usuario");
      }else{
      $this->Add($id_nonloggedUser);
      $this->ShowChatView();
      }
      }
}

?>