<?php

    namespace Controllers;

    use DAO\OwnerDAO;
    use Models\Owner;

    class OwnerController {
        private $ownerDAO;

        public function __construct() {
            $this->ownerDAO = new OwnerDAO();
        }

        public function ShowOwnerMenu($message = "") {
            //require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "owner-home.php");
        }

        public function ShowAddView($message = "") {
            //require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "add-owner.php");
        }

        public function ShowListView() {
            //require_once(VIEWS_PATH . "validate-session.php");
            $keepersList = $this->ownerDAO->GetAll();
            require_once(VIEWS_PATH . "owners-list.php");
        }

        public function Add($firstName, $lastName, $dni, $email, $phoneNumber, $username,$password) {
            //require_once(VIEWS_PATH . "validate-session.php");

            $owner = new Owner();
            

            $this->ownerDAO->Add($owner);

            $message = "Congratulations you've just become a Owner!";

            $this->ShowAddView($message);
        }

    }
?>