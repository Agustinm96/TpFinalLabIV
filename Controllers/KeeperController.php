<?php

    namespace Controllers;

    use DAO\KeeperDAO;
    use Models\Keeper;

    class KeeperController {
        private $keeperDAO;

        public function __construct() {
            $this->keeperDAO = new KeeperDAO();
        }

        public function ShowAddView() {
            //require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "add-keeper.php");
        }

        public function ShowListView() {
            //require_once(VIEWS_PATH . "validate-session.php");
            $keepersList = $this->keeperDAO->GetAll();
            //require_once(VIEWS_PATH . "keeper-list.php");
        }

        public function ShowModifyView($id) {
            //require_once(VIEWS_PATH . "validate-session.php");
            $keeper = $this->keeperDAO->GetById($idKeeper);
            //require_once(VIEWS_PATH . "modify-keeper.php");
        }
        /**/
        public function Add($array) {
            //require_once(VIEWS_PATH . "validate-session.php");

            $keeper = new Keeper();
            $keeper->setFirstName($array["firstName"]);
            $keeper->setLastName($array["lastName"]);
            $keeper->setDni($array["dni"]);
            $keeper->setEmail($array["email"]);
            $keeper->setPhoneNumber($array["phoneNumber"]);
            $keeper->setIdKeeper($array["idKeeper"]);
            $keeper->setPetSizeToKeep($array["petSizeToKeep"]);
            $keeper->setIsAvailable($array["isAvailable"]);

            $this->keeperDAO->Add($keeper);

            $this->ShowListView();
        }

        public function Remove($id) {
            //require_once(VIEWS_PATH . "validate-session.php");
            
            $this->keeperDAO->Remove($id);

            $this->ShowListView();
        }

        public function Modify($array) {
            $keeper = new Keeper();

            $keeper = new Keeper();
            $keeper->setFirstName($array["firstName"]);
            $keeper->setLastName($array["lastName"]);
            $keeper->setDni($array["dni"]);
            $keeper->setEmail($array["email"]);
            $keeper->setPhoneNumber($array["phoneNumber"]);
            $keeper->setIdKeeper($array["idKeeper"]);
            $keeper->setPetSizeToKeep($array["petSizeToKeep"]);
            $keeper->setIsAvailable($array["isAvailable"]);

            $this->keeperDAO->Modify($keeper);

            $this->ShowListView();
        }
    }
?>