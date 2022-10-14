<?php

    namespace Controllers;

    use DAO\KeeperDAO as KeeperDAO;
    use Models\Keeper as Keeper;
    use Models\Reserve as Reserve;
    use Models\User as User;

    class KeeperController {
        private $keeperDAO;

        public function __construct() {
            $this->keeperDAO = new KeeperDAO();
        }

        public function ShowHomeView($message = ""){
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "keeper-home.php"); 
        }

        public function ShowListView() { 
            require_once(VIEWS_PATH . "validate-session.php");
            $keepersList = $this->keeperDAO->GetAll();
            require_once(VIEWS_PATH . "keepers-list.php");
        }

        public function ShowMyProfile(){  
            require_once(VIEWS_PATH . "validate-session.php");
            $keeper = $this->keeperDAO->getByIdUser(($_SESSION["loggedUser"]->getId()));
            require_once(VIEWS_PATH . "keeper-profile.php");
        }

        public function ShowModifyView($message = "") {
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "keeper-modify.php");
        }

        public function setAvailabilityView(){
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "keeper-availability.php");
        }

        public function Add($adress, $initDate, $finishDate, $daysToWork, $petSizeToKeep, $priceToKeep){
            require_once(VIEWS_PATH . "validate-session.php");
            $user = new User();
            $user = ($_SESSION["loggedUser"]);

            $keeper = new Keeper();
            $keeper->setIdUser($user->getId());
            $keeper->setAdress($adress);

            $reserve = new Reserve();
            $reserve->setStartingDate($initDate);
            $reserve->setLastDate($finishDate);
            $arrayDays = array();
            if(!empty($daysToWork)){
                foreach($daysToWork as $selected){
                    array_push($arrayDays,$selected);
                }
            }
            $reserve->setArrayDays($arrayDays);
            $reserve->setIsAvailable(true);

            $keeper->setReserve($reserve);

            $array = array();
            if(!empty($petSizeToKeep)){
                foreach($petSizeToKeep as $selected){
                    array_push($array,$selected);
                }
            }
            $keeper->setPetSizeToKeep($array);
            $keeper->setPriceToKeep($priceToKeep);

            $this->keeperDAO->Add($keeper);

            $message = 'Profile succesfully completed!';

            $this->ShowHomeView($message);
        }

        public function Modify($name, $lastName, $email, $phoneNumber, $userName, $password, $adress, $petSizeToKeep, $daysToWork, $initDate, $lastDate,$priceToKeep) {
            require_once(VIEWS_PATH . "validate-session.php");

            $user = new User();
            $user = ($_SESSION["loggedUser"]);

            $user->setFirstName($name);
            $user->setLastName($lastName);
            $user->setEmail($email);
            $user->setPhoneNumber($phoneNumber);
            $user->setUserName($userName);
            $user->setPassword($password);

            $keeper = new Keeper();
            $keeper->setIdUser($user->getId());
            $keeper->setAdress($adress);
            $array = array();
            if(!empty($petSizeToKeep)){
                foreach($petSizeToKeep as $selected){
                    array_push($array,$selected);
                }
            }
            $keeper->setPetSizeToKeep($array);

            $reserve = new Reserve();
            $reserve->setStartingDate($initDate);
            $reserve->setLastDate($lastDate);
            $arrayDays = array();
            if(!empty($daysToWork)){
                foreach($daysToWork as $selected){
                    array_push($arrayDays,$selected);
                }
            }
            $reserve->setArrayDays($arrayDays);
            $reserve->setIsAvailable(true);
            $keeper->setReserve($reserve);
            $keeper->setPriceToKeep($priceToKeep);

            $this->keeperDAO->Modify($user, $keeper);

            $message = 'Profile succesfully updated!';

            $this->ShowHomeView($message);
        }

    }
?>