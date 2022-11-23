<?php

namespace Controllers;

use DAO\ChatDAO as ChatDAO;
use DAO\keeperDAO as keeperDAO;
use MODELS\User as User;
use MODELS\Chat as Chat;

class ChatController
{
  private $userController;
  private $keeperController;
  private $ownerController;
  private $keeperDAO;
  private $chatDAO;

  public function __construct()

  {
    $this->chatDAO = new ChatDAO();
    $this->keeperDAO = new KeeperDAO();
    $this->userController = new UserController();
    $this->keeperController = new KeeperController();
    $this->ownerController = new OwnerController();
  }


  public function ShowChatView($message = "")
  {
    require_once(VIEWS_PATH . "validate-session.php");

    $user = $_SESSION["loggedUser"];
    if ($user->getUserType()->getId() == 2) {
      $keeper = $this->keeperController->keeperDAO->GetByIdUser($user->getId());
      $boolean = $this->keeperController->checkingRequests($keeper);
      $chatList = $this->chatDAO->GetById_User($_SESSION["loggedUser"]->getId(), "id_Keeper");
    } else if ($user->getUserType()->getId() == 1) {
      $owner = $this->ownerController->ownerDAO->GetByIdUser(($_SESSION["loggedUser"]->getId()));
      $ownerBoolean = $this->ownerController->checkingIfAreInvoicesToPay($owner);
      $chatList = $this->chatDAO->GetById_User($_SESSION["loggedUser"]->getId(), "id_Owner");
    }

    require_once(VIEWS_PATH . "chat-list.php");
  }

  public function getAllKeepers()
  {
    require_once(VIEWS_PATH . "validate-session.php");
    $result = $this->keeperDAO->GetAll();
    $chatList = $this->chatDAO->GetById_User($_SESSION["loggedUser"]->getId(), "id_Owner");
    require_once(VIEWS_PATH . "chat-list.php");
  }

  public function lookForKeeper($searchParameter)
  {
    require_once(VIEWS_PATH . "validate-session.php");
    if (!$searchParameter) {
      $result = $this->keeperDAO->GetAll();
    } else {
      $result = $this->keeperDAO->getByNameOrLastName($searchParameter);
    }
    if ($_SESSION["loggedUser"]->getUserType()->getId() == 1) {
      $owner = $this->ownerController->ownerDAO->GetByIdUser(($_SESSION["loggedUser"]->getId()));
      $ownerBoolean = $this->ownerController->checkingIfAreInvoicesToPay($owner);
      $chatList = $this->chatDAO->GetById_User($_SESSION["loggedUser"]->getId(), "id_Owner");
    }
    require_once(VIEWS_PATH . "chat-list.php");
  }



  public function Add($id_Keeper)
  {
    $newchat = new Chat();
    $userAux = new User();
    $userAux2 = new User();
    $userAux->setId($id_Keeper); // ID keeper
    $newchat->setId_Keeper($userAux); //seteo el ID del keeper
    $userAux2->setId($_SESSION["loggedUser"]->getId()); //cambio al ID logeado
    $newchat->setId_Owner($userAux2); // ID OWNER que esta logeado
    $this->chatDAO->Add($newchat);
  }


  public function NewChat($id_nonloggedUser)
  {
    require_once(VIEWS_PATH . "validate-session.php");
    $flag = 0;
    $chatList = $this->chatDAO->GetById_User($_SESSION["loggedUser"]->getId(), "id_Owner");
    if ($chatList != null) {
      foreach ($chatList as $chat) {
        if ($chat->getId_Keeper()->getId() == $id_nonloggedUser) {
          $flag = 1;
        }
      }
    }
    if ($flag == 1) {
      $this->ShowChatView("Ya posees un chat iniciado con este usuario");
    } else {
      $this->Add($id_nonloggedUser);
      $this->ShowChatView();
    }
  }
}
