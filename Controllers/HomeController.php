<?php
    namespace Controllers;
    use DAO\UserDAO;
    class HomeController
    {

        private $userDAO;

        public function __construct() {
            $this->userDAO = new UserDAO();
        }
        public function Index($message = "") {
            require_once(VIEWS_PATH . "user-login.php");
        }

        public function showAddView($idType){
            if($idType==1){
                require_once(VIEWS_PATH."owner-home.php");
            }else if($idType==2){
                echo "Soy un keeper";
                //require_once(VIEWS_PATH."keeper-home.php");
            }else if($idType==3){
                require_once(VIEWS_PATH."admin.php");
            }
        }

        public function Login($username, $password) {
            $user = $this->userDAO->GetByUserName($username);

            if(($user != null) && ($user->getPassword() === $password)) {
                
                $_SESSION["loggedUser"] = $user;
                
                $this->showAddView($user->getUserType()->getId());
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