<?php

    namespace Controllers;

    use DAO\KeeperDAO as KeeperDAO;
    use DAO\UserDAO as UserDAO;
    use DAO\PetDAO as PetDAO;
    use Models\Keeper as Keeper;
    use Models\Reserve as Reserve;
    use Models\Pet;
    use Models\Dog;
    use Models\Cat;
    use Models\User as User;
    use Models\Availability;

    class KeeperController {
        public $keeperDAO;
        private $userDAO;
        private $petController;
        private $availabilityController;
        private $reserveRequestController;
        
        

        public function __construct() {
            $this->keeperDAO = new KeeperDAO();
            $this->userDAO = new UserDAO();
            $this->petController = new PetController();
            $this->availabilityController = new AvailabilityController();
            $this->reserveRequestController = new ReserveRequestController();
        }

        public function ShowHomeView($message = ""){
            require_once(VIEWS_PATH . "validate-session.php");
            $keeper = $this->keeperDAO->getByIdUser(($_SESSION["loggedUser"]->getId()));
            $boolean = $this->checkingRequests($keeper);
            require_once(VIEWS_PATH . "home.php"); 
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
            $availabilityList = $this->availabilityController->availabilityDAO->GetAll();
            
            if($initDate <= $lastDate){
                $keepersList = $this->keeperDAO->getAvailableKeepersByDates($availabilityList, $initDate, $lastDate);

                require_once(VIEWS_PATH . "keepers-list.php");
            }else{
                $message = "ERROR: The dates you selected are invalid! Please select them again";
                require_once(VIEWS_PATH . "loading-dates.php");
            }
            
        }

        public function ShowMyAvailability($message = ""){
            require_once(VIEWS_PATH . "validate-session.php");
            if($_SESSION["loggedUser"]->getUserType()->getId()==2){
                $keeper = $this->keeperDAO->getByIdUser(($_SESSION["loggedUser"]->getId()));
                $boolean = $this->checkingRequests($keeper);
            }
            require_once(VIEWS_PATH . "keeper-availability.php");
        }

        public function ShowCompletionProfile($message = ""){
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "profile-completion-keeper.php");
        }

        public function ShowPendingReserves($message=""){
            require_once(VIEWS_PATH . "validate-session.php");
            $keeper = $this->keeperDAO->getByIdUser(($_SESSION["loggedUser"]->getId()));
            $pendingReservesList = $this->loadPendingReservesList($keeper);
            $boolean = $this->checkingRequests($keeper);
            require_once(VIEWS_PATH . "keeper-pendingReserves.php");
        }

        public function Add($adress, $initDate, $finishDate, $daysToWork, $petSizeToKeep, $priceToKeep, $petsAmount){ 
            require_once(VIEWS_PATH . "validate-session.php");
            $boolean = $this->checkingDates($initDate, $finishDate, $daysToWork);
            if($boolean){
                $keeper = new Keeper();
                $keeper = $this->loadKeeper($adress, $initDate, $finishDate, $daysToWork,$petSizeToKeep, $priceToKeep, $petsAmount);

                $keeper->setIdKeeper($this->keeperDAO->Add($keeper));
                
                //$this->keeperDAO->Add($keeper);
                $this->availabilityController->Add($keeper, $initDate, $finishDate, $daysToWork);

                $message = 'Profile succesfully completed!';

                $this->ShowHomeView($message);
            }else{
                $message = 'ERROR: The dates you have chosed dont match the days you want to work. Please select them again!';
                $this->ShowCompletionProfile($message);
            } 
        }

        public function ModifyAvailability($idKeeper, $adress, $initDate, $lastDate, $daysToWork,$petSizeToKeep, $priceToKeep, $petsAmount){   
            require_once(VIEWS_PATH . "validate-session.php");
            $boolean = $this->checkingDates($initDate, $lastDate, $daysToWork);
            if($boolean){

            $keeper = new Keeper();
            $keeper = $this->loadKeeper($adress, $initDate, $lastDate, $daysToWork,$petSizeToKeep, $priceToKeep, $petsAmount);
            $keeper->setIdKeeper(intval($idKeeper));

            $this->keeperDAO->Modify($keeper);
            $this->availabilityController->Modify($keeper, $initDate, $lastDate, $daysToWork);

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

        public function loadKeeper($adress, $initDate, $finishDate, $daysToWork,$petSizeToKeep, $priceToKeep, $petsAmount){
            $user = new User();
            $user = ($_SESSION["loggedUser"]);

            $keeper = new Keeper();
            $keeper->setUser($user);
            $keeper->setAdress($adress);
            $keeper->setStartingDate($initDate);
            $keeper->setLastDate($finishDate);
            $arrayDays = array();
            if(!empty($daysToWork)){
                foreach($daysToWork as $selected){
                    array_push($arrayDays,$selected);
                }
            }
            $keeper->setArrayDays($arrayDays);
            $keeper->setPetSizeToKeep($petSizeToKeep);
            $keeper->setPriceToKeep($priceToKeep);
            $keeper->setPetsAmount($petsAmount);

            return $keeper;
        }

        public function loadPendingReservesList($keeper){
            $arrayToReturn = array();
            $reserveRequestList = $this->reserveRequestController->reserveRequestDAO->GetAll();
            
            if(is_array($reserveRequestList)){
                foreach($reserveRequestList as $reserve){
                $availabilityAux = $this->availabilityController->availabilityDAO->GetById($reserve->getAvailabilityId());
                
                if($availabilityAux->getIdKeeper() == $keeper->getIdKeeper()){
                    $petAux = $this->petController->petDAO->GetById($reserve->getPetId());
                        $reserveToReturn["availabilityId"] = $availabilityAux->getId();
                        $reserveToReturn["reserveId"] = $reserve->getId();
                        $reserveToReturn["date"] = $availabilityAux->getDate();
                        $reserveToReturn["pet"] = $petAux;
                        array_push($arrayToReturn, $reserveToReturn);
                    }
                }
            }else{
                if($reserveRequestList){
                    $availabilityAux = $this->availabilityController->availabilityDAO->GetById($reserveRequestList->getAvailabilityId());
                    if($availabilityAux->getIdKeeper() == $keeper->getIdKeeper()){
                        $petAux = $this->petController->petDAO->GetById($reserveRequestList->getPetId());
                        $reserveToReturn["availabilityId"] = $availabilityAux->getId();
                        $reserveToReturn["reserveId"] = $reserveRequestList->getId();
                        $reserveToReturn["date"] = $availabilityAux->getDate();
                        $reserveToReturn["pet"] = $petAux;
                        array_push($arrayToReturn, $reserveToReturn);
                    }
                    
                }
                
            }

            return $arrayToReturn;
        }

        public function checkingReserves($keeper){
            $reservesArray = $this->reserveController->reserveDAO->GetAll();
            $arrayToReturn = array();

            foreach($reservesArray as $reserve){
                $availabilityAux = $this->availabilityController->availabilityDAO->GetById($reserve->getId());
                if($availabilityAux->getIdKeeper() == $keeper->getIdKeeper()){
                    array_push($arrayToReturn, $reserve);
                } 
            }
            return $arrayToReturn;
        }

        public function checkingRequests($keeper){
            $boolean = false;
            $reserveRequestList = $this->reserveRequestController->reserveRequestDAO->GetAll();

            if(is_array($reserveRequestList)){
                foreach($reserveRequestList as $reserve){
                $availabilityAux = $this->availabilityController->availabilityDAO->GetById($reserve->getAvailabilityId());

                if($keeper->getIdKeeper() == $availabilityAux->getIdKeeper()){
                    $boolean = true;
                    }
                }
            }elseif($reserveRequestList){
                $availabilityAux = $this->availabilityController->availabilityDAO->GetById($reserveRequestList->getAvailabilityId());
                if($keeper->getIdKeeper() == $availabilityAux->getIdKeeper()){
                    $boolean = true;
                    }
                }
            return $boolean;
        }

    }
?>