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
        private $keeperDAO;
        private $userDAO;
        private $petDAO;

        public function __construct() {
            $this->keeperDAO = new KeeperDAO();
            $this->userDAO = new UserDAO();
            $this->petDAO = new petDAO();
        }

        public function ShowHomeView($message = ""){
            require_once(VIEWS_PATH . "validate-session.php");
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

        public function ShowLoadReserveView($id, $message = ""){
            require_once(VIEWS_PATH . "validate-session.php");
            $keeper = $this->keeperDAO->GetById($id);
            $petList = $this->petDAO->GetByUserName($_SESSION["loggedUser"]->GetUserName());
            require_once(VIEWS_PATH . "load-reserve.php");
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

        public function generatingReserve($date, $petList, $keeperId, $userName){
            $keeper = new Keeper();
            $keeper = $this->keeperDAO->GetById($keeperId);
            
            $boolean1 = $this->checkingAvailability($keeper, $date);

            $petArray = $this->loadingPetsArray($petList);

            $boolean2 = $this->checkingPetType($petArray);

            $boolean3 = $this->checkingPetSize($petArray, $keeper);

            if($boolean1 && $boolean2 && $boolean3){
            $availabilityArray = $keeper->getavailabilityArray();

            foreach($availabilityArray as $day){
                if($day->getDate() == $date){

                    $arrayNames = $day->getUserName();
                    array_push($arrayNames, $userName);
                    $day->setUserName($arrayNames); 

                    $arrayPets = $day->getPetList();
                    foreach($petArray as $pet){
                        array_push($arrayPets, $pet);
                    }
        
                    $day->setPetList($arrayPets); 

                    $this->keeperDAO->Modify($keeper);
                    $message = 'Reservation successfully made';
                    $this->ShowHomeView($message);    
                    }
                }
            }else{
                if(!$boolean1){
                    $message = 'ERROR: The keeper is not available on that date. Please select them again!';
                }else if(!$boolean2){
                    $message = "ERROR: You can only choose one pet type, either dog or cat.";
                }else if(!$boolean3){
                    $message = "ERROR: The size of your pet doesn't match what the keeper can handle!";
                }
                $this->ShowLoadReserveView($keeperId, $message);
            }
        }

        public function checkingPetSize($petsArray, $keeper){
            $boolean = false;
            $sizeArray = $keeper->getPetSizeToKeep();
            foreach($petsArray as $pet){
                foreach($sizeArray as $size){
                    if($pet->getSize() == $size){
                        $boolean = true;
                    }
                }
            }
            return $boolean;
        }

        public function checkingPetType($petsArray){
            $petType1 = "dog";
            $dogCounter=0;
            $petType2 = "cat";
            $catCounter = 0;

            foreach($petsArray as $pet){
                if($pet->getPetType()=="dog"){
                    $dogCounter++;
                }else if($pet->getPetType()=="cat"){
                    $catCounter++;
                }
            }
            if($dogCounter>1 || $catCounter>1){
                return false;
            }else{
                return true;
            }

        }

        public function loadingPetsArray($petList){
            $arrayPets = array();
            foreach($petList as $pet){
                $petAux = $this->petDAO->GetById($pet);
                
                if($petAux->getPetType()=="dog"){
                    
                    $dog = new Dog();
                    $dog = $this->petDAO->GetById($petAux->getIDPET());
                    array_push($arrayPets, $dog);
                }else if($petAux->getPetType()=="cat"){
                    $cat = new Cat();
                    $cat = $this->petDAO->GetById($petAux->getIDPET());
                    array_push($arrayPets, $cat);
                }
            }
            return $arrayPets;
        }
    

        public function checkingAvailability($keeper, $date){
            $boolean = false;
            $availabilityArray = $keeper->getavailabilityArray();

            foreach($availabilityArray as $day){
                if($day->getDate() == $date && $day->getAvailable()==true){
                    $boolean = true;
                }
            }
            return $boolean;
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