<?php
    namespace Controllers;
    use DAO\UserDAO;
    class HomeController
    {

        private $userDAO;
        private $keeperController;

        public function __construct() {
            $this->userDAO = new UserDAO();
            $this->keeperController = new KeeperController();
        }
        public function Index($message = "") {
            require_once(VIEWS_PATH . "user-login.php");
        }

        public function showAddView(){
            require_once(VIEWS_PATH . "validate-session.php");
            if($_SESSION["loggedUser"]->getUserType()->getId()==2){
                $keeper = $this->keeperController->keeperDAO->getByIdUser(($_SESSION["loggedUser"]->getId()));
                $boolean = $this->keeperController->checkingRequests($keeper);
            }
            require_once(VIEWS_PATH."home.php");
        }

        public function Login($username, $password) {
            $user = $this->userDAO->GetByUserName($username);

            if(($user != null) && ($user->getPassword() === $password)) {
                
                $_SESSION["loggedUser"] = $user;
                
                $this->showAddView();
            } else {
                $this->Index("Usuario y/o contraseña incorrecta");
            }
        }

        public function Logout() {
            session_destroy();

            $this->Index();
        }
    }
?>