<?php

    namespace Controllers;

    use DAO\OwnerDAO;
    use Models\Owner;

    class KeeperController {
        private $ownerDAO;

        public function __construct() {
            $this->ownerDAO = new OwnerDAO();
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
            $owner->setFirstName($firstName);
            $owner->setLastName($lastName);
            $owner->setDni($dni);
            $owner->setEmail( $email);
            $owner->setPhoneNumber($phoneNumber);
            $owner->setUsername($username);
            $owner->setPassword($password);

            $this->ownerDAO->Add($owner);

            $message = "Congratulations you've just become a Owner!";

            $this->ShowAddView($message);
        }

    }
?>