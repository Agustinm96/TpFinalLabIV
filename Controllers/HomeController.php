<?php
    namespace Controllers;

    class HomeController
    {
        public function Index($message = "") {
            require_once(VIEWS_PATH . "add-keeper.php");
        }

        public function ShowAddView() {
            require_once(VIEWS_PATH . "add-keeper.php");
            /*require_once(VIEWS_PATH . "validate-session.php");*/
           
        }

        public function ShowListView(){
            $keeperDAO = new KeeperDAO();
            $keepersList = $keeperDAO->GetAll();
            require_once(VIEWS_PATH . 'keepers-list.php');
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