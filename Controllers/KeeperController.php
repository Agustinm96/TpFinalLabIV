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

        public function __construct() {
            $this->keeperDAO = new KeeperDAO();
            $this->userDAO = new UserDAO();
            $this->petController = new PetController();
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

            if($initDate <= $lastDate){
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
            //$keeper = $this->keeperDAO->getByIdUser(($_SESSION["loggedUser"]->getId()));
            require_once(VIEWS_PATH . "keeper-availability.php");
        }

        public function ShowModifyAvailabilityView($message = "") {
            require_once(VIEWS_PATH . "validate-session.php");
            $keeper = $this->keeperDAO->getByIdUser(($_SESSION["loggedUser"]->getId()));
            $boolean = $this->checkingReserves($keeper);
            if($boolean){
                $message = "ERROR: If you have pending reservations, it's impossible to modify your availability. We're sorry";
                $this->ShowMyAvailability($message);
            }
            else{
                require_once(VIEWS_PATH . "keeper-modify-availability.php");
            }  
        }

        public function ShowCompletionProfile($message = ""){
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH . "profile-completion-keeper.php");
        }

        public function ShowReserveView($message=""){
            require_once(VIEWS_PATH . "validate-session.php");
            if($_SESSION["loggedUser"]->getUserType()->getId()==2){
                $keeper = $this->keeperDAO->getByIdUser(($_SESSION["loggedUser"]->getId()));
                $boolean = $this->checkingRequests($keeper);
            }
            $reserveList = $this->loadReserveList();
            require_once(VIEWS_PATH . "keeper-reserve.php");
        }

        public function ShowPendingReserves($message=""){
            require_once(VIEWS_PATH . "validate-session.php");
            $keeper = $this->keeperDAO->getByIdUser(($_SESSION["loggedUser"]->getId()));
            $pendingReservesList = $this->loadPendingReservesList($keeper);
            $boolean = $this->checkingRequests($keeper);
            require_once(VIEWS_PATH . "keeper-pendingReserves.php");
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
                        $availability->setUserName(null);
                        $availability->setPetList(null);
                        $availability->setFinalCustomers(null);
                        array_push($datesArray, $availability);
                    }
                } 
                $startingDay = date('Y-m-d', strtotime($startingDay)+86400);  
            }
            return $datesArray;
        }

        public function loadReserveList(){
            $user = new User();
            $user = ($_SESSION["loggedUser"]);
            
            $keeper = new Keeper();
            $keeper->setUser($user);

            $reservesList = array();

            $keeper=$this->keeperDAO->GetByIdUser($user->getId());
            $availabilityArray = $keeper->getavailabilityArray();

            foreach($availabilityArray as $availability){
                
                $arrayFinal = $availability->getFinalCustomers();
                if($arrayFinal){
                    foreach($arrayFinal as $customer){
                        $availabilityAux = new Availability();
                        $availabilityAux->setDate($availability->getDate());
                        $availabilityAux->setUserName($customer["userName"]);
                        $availabilityAux->setPetList($customer["petNameType"]);
                        array_push($reservesList, $availabilityAux);
                    }
                }    
            }
            return $reservesList;
        }

        public function loadPendingReservesList($keeper){
            $availabilityArray = $keeper->getavailabilityArray();
            $arrayToReturn = array();
            foreach($availabilityArray as $availability){
                $boolean = $availability->getReserveRequest();
                if($boolean){
                    $arrayUserName = $availability->getUserName();
                    $i=0;
                        while($i<count($arrayUserName)){
                            $arrayPets= $availability->getPetList();
                            $availabilityAux = new Availability();
                            $availabilityAux->setDate($availability->getDate());
                            $availabilityAux->setAvailable($availability->getAvailable());
                            $availabilityAux->setReserveRequest($availability->getReserveRequest());
                            $availabilityAux->setUserName($arrayUserName[$i]);
                            $availabilityAux->setPetList($arrayPets[$i]);
                            array_push($arrayToReturn, $availabilityAux);
                            $i++; 
                        }
                }
            }
                return $arrayToReturn;
        }

        public function Remove($id)
        {
            $this->keeperDAO->Remove($id); 
            $this->userDAO->Remove($id);           

            $this->ShowListView();
        }

        public function checkingReserves($keeper){
            $availabilityArray = $keeper->getavailabilityArray();
            foreach($availabilityArray as $availability){
                $userNameArray = $availability->getUserName();
                if($userNameArray){
                    return true;
                }
            }
        }

        public function modifyingReserve($date, $userName, $petName, $value){
            $user = new User();
            $user = ($_SESSION["loggedUser"]);
            $keeper = new Keeper();
            $keeper->setUser($user);
            $keeper = $this->keeperDAO->GetByIdUser($user->getId());
            
            $availabilityArray=$keeper->getavailabilityArray();
            
            if($value==1){
                $array = $this->confirmingReserve($availabilityArray, $date, $userName, $petName, $value);
                if($array){
                    $keeper->setAvailabilityArray($array);
                    $this->keeperDAO->Modify($keeper);
                    $message = 'Reserve updated!';
                    $this->ShowHomeView($message);
                }else{
                    $message = "ERROR: you can only accept pet's of the same type.";
                    $this->ShowPendingReserves($message);
                }
            }elseif($value==2){
                $arrayAux = $this->cancelingReserve($availabilityArray, $date, $userName, $petName, $value);
                $keeper->setAvailabilityArray($arrayAux);
                $this->keeperDAO->Modify($keeper);
                $message = 'Reserve updated!';
                $this->ShowHomeView($message);
            }
        }

        public function cancelingReserve($availabilityArray, $date, $userName, $petName){
            
            foreach($availabilityArray as $availability){
                if($availability->getDate()==$date){
                    $arrayUserName = $availability->getUserName();
                    $posToDelete = array_search($userName, array_values($arrayUserName));
                    unset($arrayUserName[$posToDelete]);

                    $availability->setUserName($arrayUserName);
                    
                    if(!$arrayUserName){
                        $availability->setReserveRequest(false);
                    }

                    $arrayPetName = $availability->getPetList();
                    $posToDeletePet = array_search($petName, array_values($arrayPetName));
                    unset($arrayPetName[$posToDeletePet]);
                    
                    $availability->setPetList($arrayPetName);
                }
            }
            return $availabilityArray;
        }


        public function confirmingReserve($availabilityArray, $date, $userName, $petName){
            
            foreach($availabilityArray as $availability){
                if($availability->getDate()==$date){
                    $arrayUserName = $availability->getUserName();
                    $posToDelete = array_search($userName, array_values($arrayUserName));
        
                    $arrayPetName = $availability->getPetList();
                    $posToDeletePet = array_search($petName, array_values($arrayPetName));
                    
                    $finalCustomersArray = $availability->getFinalCustomers();
                    //$boolean1 = $this->validateArraySize($finalCustomersArray);
                    $boolean2 = $this->validateType($finalCustomersArray, $petName);
                    if($finalCustomersArray){
                        if($boolean2){
                            $value["userName"] = $userName;
                            $value["petNameType"] = $petName;
                            array_push($finalCustomersArray, $value);
                        }else{
                            return null;
                        }
                        
                    }else{
                        $value["userName"] = $userName;
                        $value["petNameType"] = $petName;
                        array_push($finalCustomersArray, $value);
                    }
                    
                    unset($arrayUserName[$posToDelete]);
                    unset($arrayPetName[$posToDeletePet]);
                    $availability->setUserName($arrayUserName);
                    $availability->setPetList($arrayPetName);
                    if(!$arrayUserName){
                        $availability->setReserveRequest(false);
                    }
                    $availability->setFinalCustomers($finalCustomersArray);
                    
                    $boolean = $this->validateArraySize($finalCustomersArray);
                    if(!$boolean){
                        $availability->setAvailable(false);
                    }
                }
            }
            return $availabilityArray;
        }

        public function validateType($array, $petName){
            $boolean = false;
            
            $substring1 = substr($petName, -3);
            foreach($array as $name){
                $typeName = substr($name["petNameType"], -3);
                if($substring1 == $typeName){
                    $boolean = true;
                }
            }
            return $boolean;
        }

        public function validateArraySize($array){
            $count = count($array);
            if($count>=2){
                return false;
            }else{
                return true;
            }
        }

        public function checkingRequests($keeper){
            $boolean = false;
            $availabilityArray = $keeper->getavailabilityArray();
            if($availabilityArray){
                foreach($availabilityArray as $availability){
                    $booleanAux = $availability->getReserveRequest();
                    if($booleanAux){
                        $boolean = true;
                    }
                }
            }
            return $boolean;
        }

    }
?>