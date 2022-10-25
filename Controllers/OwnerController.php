<?php

namespace Controllers;

use DAO\UserDAO as UserDAO;
use DAO\OwnerDAO;
use DAO\PetDAO;
use DAO\KeeperDAO;
use Models\Owner;
use Models\User as User;
use Models\Pet;

class OwnerController
{
    private $ownerDAO;
    private $userDAO;
    public function __construct()
    {
        $this->ownerDAO = new OwnerDAO();
        $this->userDAO = new UserDAO();
        $this->keeperDAO = new KeeperDAO();
        $this->petDAO  = new PetDAO();
    }

    public function ShowHomeView($message = "")
    {
        //require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "home.php");
    }

    public function ShowAddView($message = "")
    {
        //require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "owner-home.php");
    }

    public function ShowListView()
    {
        require_once(VIEWS_PATH . "validate-session.php");
        $ownersList = $this->ownerDAO->GetAll();
        $usersList = $this->userDAO->GetAll();

        foreach ($ownersList as $owner) {
            $userId = $owner->getUser()->getId();
            $users = array_filter($usersList, function ($user) use ($userId) {
                return $user->getId() == $userId;
            });

            $users = array_values($users); //Reordering array

            $user = (count($users) > 0) ? $users[0] : new User();

            $owner->setUser($user);
        }

        require_once(VIEWS_PATH . "owners-list.php");
    }

    public function ShowAskForAKeeper($message = "")
    {
        require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "loading-dates.php");
    }

    public function ShowMyProfile(){  
        require_once(VIEWS_PATH . "validate-session.php");
        $owner = $this->ownerDAO->getByIdUser(($_SESSION["loggedUser"]->getId()));
        require_once(VIEWS_PATH . "owner-profile.php");
    }

    public function ShowGenerateReserveView($id)
    {
        require_once(VIEWS_PATH . "validate-session.php");
        $keeper = $this->keeperDAO->GetByIdUser($id);
        $petList = $this->petDAO->GetByUserName($_SESSION["loggedUser"]->GetUserName());
        require_once(VIEWS_PATH . "load-reserve.php");
    }

    public function Add($adress)
    {
        require_once(VIEWS_PATH . "validate-session.php");
        $user = new User();
        $user->setId($_SESSION["loggedUser"]->getId());

        $owner = new Owner();
        $owner->setUser($user);
        $owner->setAdress($adress);

        $this->ownerDAO->Add($owner);

        $message = 'Profile succesfully completed!';

        $this->ShowHomeView($message);
    }

    public function Remove($idUser)
    {
        $this->ownerDAO->Remove($idUser);
        $this->userDAO->Remove($idUser);
        $this->ShowListView();
    }
}
