<?php
    namespace Controllers;

    class HomeController
    {
        public function Index($message = "") {
            require_once(VIEWS_PATH . "home.php");
        }


        /*public function Login($userName, $password) {
            $user = $this->userDAO->GetByUserName($userName);

            if(($user != null) && ($user->getPassword() === $password)) {
                $_SESSION["loggedUser"] = $user;
                $this->ShowAddView();
            } else {
                $this->Index("Usuario y/o contraseña incorrecta");
            }

        }*/

        public function Logout() {
            session_destroy();

            $this->Index();
        }
    }
?>