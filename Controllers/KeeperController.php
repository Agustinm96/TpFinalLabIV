<?php

    namespace Controllers;

    use DAO\KeeperDAO as KeeperDAO;
    use DAO\UserDAO as UserDAO;
    use Models\Keeper as Keeper;
    use Models\Reserve as Reserve;
    use Models\User as User;
    use Models\Availability;

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

        public function ShowAvailableListView($initDate, $lastDate){
            require_once(VIEWS_PATH . "validate-session.php");   
            $keepersList = $this->keeperDAO->getAvailableKeepersByDates($initDate, $lastDate);
            
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

        public function ShowMyAvailability(){
            require_once(VIEWS_PATH . "validate-session.php");
            $keeper = $this->keeperDAO->getByIdUser(($_SESSION["loggedUser"]->getId()));
            require_once(VIEWS_PATH . "keeper-availability.php");
        }

        public function ShowModifyAvailabilityView($message = "") {
            require_once(VIEWS_PATH . "validate-session.php");
            $keeper = $this->keeperDAO->getByIdUser(($_SESSION["loggedUser"]->getId()));
            require_once(VIEWS_PATH . "keeper-modify-availability.php");
        }

        public function ShowCompletionProfile($message = ""){
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "profile-completion-keeper.php");
        }

        public function ShowReserveView($message=""){
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "keeper-reserve.php");
        }

        public function Add($adress, $initDate, $finishDate, $daysToWork, $petSizeToKeep, $priceToKeep){
            require_once(VIEWS_PATH . "validate-session.php");
            $boolean = $this->checkingDates($initDate, $finishDate, $daysToWork);
            if($boolean){
                $user = new User();
                $user->setId($_SESSION["loggedUser"]->getId());
                
                $keeper = new Keeper();
                $keeper->setUser($user);
                $keeper = $this->loadKeeper($adress, $initDate, $finishDate, $daysToWork,$petSizeToKeep, $priceToKeep);

                $this->keeperDAO->Add($keeper);

                $message = 'Profile succesfully completed!';

                $this->ShowHomeView($message);
            }else{
                $message = 'ERROR: The dates you have chosed dont match the days you want to work. Please select them again!';
                $this->ShowCompletionProfile($message);
            } 
        }

        public function ModifyAvailability($idKeeper, $adress, $initDate, $lastDate, $daysToWork,$petSizeToKeep, $priceToKeep){   
            require_once(VIEWS_PATH . "validate-session.php");
            $boolean = $this->checkingDates($initDate, $lastDate, $daysToWork);
            if($boolean){

            $keeper = new Keeper();
            $keeper = $this->loadKeeper($adress, $initDate, $lastDate, $daysToWork,$petSizeToKeep, $priceToKeep);
            $keeper->setIdKeeper(intval($idKeeper));

            $this->keeperDAO->Modify($keeper);
            $message = 'Profile succesfully updated!';
            $this->ShowHomeView($message);

            }else{
                $message = 'ERROR: The dates you have chosed dont match the days you want to work. Please select them again!';
                $this->ShowModifyAvailabilityView($message);
            }
            
        }

        public function checkingDates($startingDay, $finishDate, $daysToWork){
            while($startingDay <= $finishDate){
                $string = $this->dayName($startingDay);
                foreach($daysToWork as $day){
                    if($string===$day){
                        return true;
                    }
                } 
                $startingDay = date('Y-m-d', strtotime($startingDay)+86400);     
            } 
        }

        public function dayName($startingDay){
            $fechats = strtotime($startingDay); 
            switch (date('w', $fechats)){
                case 0: return "Sunday"; break;
                case 1: return "Monday"; break;
                case 2: return "Tuesday"; break;
                case 3: return "Wednesday"; break;
                case 4: return "Thursday"; break;
                case 5: return "Friday"; break;
                case 6: return "Saturday"; break;
                }  
        }

        public function loadKeeper($adress, $initDate, $finishDate, $daysToWork,$petSizeToKeep, $priceToKeep){
            $user = new User();
            $user = ($_SESSION["loggedUser"]);

            $keeper = new Keeper();
            $keeper->setUser($user);
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

            $keeper->setReserve($reserve);

            $array = array();
            if(!empty($petSizeToKeep)){
                foreach($petSizeToKeep as $selected){
                    array_push($array,$selected);
                }
            }
            $keeper->setPetSizeToKeep($array);
            $keeper->setPriceToKeep($priceToKeep);

            $datesArray = $this->valiDate($initDate, $finishDate, $daysToWork);
            $keeper->setAvailabilityArray($datesArray);


            return $keeper;
        }

        public function valiDate($startingDay, $finishDate, $daysToWork){
            $datesArray = array();
            while($startingDay <= $finishDate){
                $string = $this->dayName($startingDay);
                foreach($daysToWork as $day){
                    if($string===$day){
                        $availability = new Availability();
                        $availability->setDate($startingDay);
                        $availability->setAvailable(true);
                        array_push($datesArray, $availability);
                    }
                } 
                $startingDay = date('Y-m-d', strtotime($startingDay)+86400);  
            }
            return $datesArray;
        }

        public function Remove($id)
        {
            $this->keeperDAO->Remove($id); 
            $this->userDAO->Remove($id);           

            $this->ShowListView();
        }
    }
?>