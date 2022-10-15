<?php

    namespace Controllers;

    use DAO\KeeperDAO as KeeperDAO;
    use DAO\UserDAO as UserDAO;
    use Models\Keeper as Keeper;
    use Models\Reserve as Reserve;
    use Models\User as User;

    class KeeperController {
        private $keeperDAO;
        private $userDAO;

        public function __construct() {
            $this->keeperDAO = new KeeperDAO();
            $this->userDAO = new UserDAO();
        }

        public function ShowHomeView($message = ""){
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "keeper-home.php"); 
        }

        public function ShowListView() { 
            require_once(VIEWS_PATH . "validate-session.php");
            $keepersList = $this->keeperDAO->GetAll();
            $usersList = $this->userDAO->GetAll();

            foreach($keepersList as $keeper)
            {
                $userId = $keeper->getUser()->getId();
                $users = array_filter($usersList, function($user) use($userId){                    
                    return $user->getId() == $userId;
                });

                $users = array_values($users); //Reordering array

                $user = (count($users) > 0) ? $users[0] : new User(); 

                $keeper->setUser($user);
            }

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

        public function setAvailabilityView($message = ""){
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "keeper-availability.php");
        }

        public function Add($adress, $initDate, $finishDate, $daysToWork, $petSizeToKeep, $priceToKeep){
            require_once(VIEWS_PATH . "validate-session.php");
            if($this->valiDate($initDate, $finishDate)){
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
            }else{
                $message = 'ERROR: Your final day as a keeper at Pet Hero must be higher than your initial day';
                $this->setAvailabilityView($message);
            }
            
            
        }

        public function Remove($id)
        {
            $this->keeperDAO->Remove($id);            

            $this->ShowListView();
        }


        //CORREGIR
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
            $keeper->setIdUser($user->getId());  //Corregir como el Add
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

        public function valiDate($initDate, $finishDate){
            if($initDate<$finishDate){
               return true; 
            }else{
                return false;
            }
        }

    }
?>