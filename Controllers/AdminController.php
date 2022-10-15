<?php

namespace Controllers;

use DAO\UserDAO as UserDAO;
use Models\Admin;
use Models\User as User;

class AdminController
{
    private $userDAO;
    public function __construct()
    {
        $this->userDAO = new UserDAO();
    }

    public function ShowHomeView($message = "")
    {
        //require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "admin.php");
    }
}