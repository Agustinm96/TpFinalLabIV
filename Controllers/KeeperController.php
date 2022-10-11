<?php

    namespace Controllers;

    use DAO\KeeperDAO;
    use Models\Keeper;

    class KeeperController {
        private $keeperDAO;

        public function __construct() {
            $this->keeperDAO = new KeeperDAO();
        }

        public function ShowAddView($message = "") {
            //require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "add-keeper.php");
        }

        public function ShowListView() {
            //require_once(VIEWS_PATH . "validate-session.php");
            $keepersList = $this->keeperDAO->GetAll();
            require_once(VIEWS_PATH . "keepers-list.php");
        }

        public function Add($firstName, $lastName, $dni, $email, $phoneNumber, $petSizeToKeep) {
            //require_once(VIEWS_PATH . "validate-session.php");

            $keeper = new Keeper();
            $keeper->setFirstName($firstName);
            $keeper->setLastName($lastName);
            $keeper->setDni($dni);
            $keeper->setEmail( $email);
            $keeper->setPhoneNumber($phoneNumber);
            $array = array();
            if(!empty($petSizeToKeep)){
                foreach($petSizeToKeep as $selected){
                    echo $selected;
                    array_push($array,$selected);
                }
            }
            $keeper->setPetSizeToKeep($array);
            $keeper->setIsAvailable(true);

            $this->keeperDAO->Add($keeper);

            $message = "Congratulations you've just become a Keeper!";

            $this->ShowAddView($message);
        }

    }
?>