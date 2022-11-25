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
        private $reserveController;
        private $invoiceController;
        private $emailController;

        public function __construct() {
            $this->keeperDAO = new KeeperDAO();
            $this->userDAO = new UserDAO();
            $this->petController = new PetController();
            $this->availabilityController = new AvailabilityController();
            $this->reserveController = new ReserveController();
            $this->invoiceController = new InvoiceController();
            $this->emailController = new EmailController();
            
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
            
            if($_SESSION["loggedUser"]->getUserType()->getId()==1){
                $owner = $this->ownerController->ownerDAO->GetByIdUser(($_SESSION["loggedUser"]->getId()));
                $ownerBoolean = $this->ownerController->checkingIfAreInvoicesToPay($owner);
            }

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

        public function ShowReserveView(){
            require_once(VIEWS_PATH . "validate-session.php");
                if($_SESSION["loggedUser"]->getUserType()->getId()==2){
                    $keeper = $this->keeperDAO->getByIdUser(($_SESSION["loggedUser"]->getId()));
                    $boolean = $this->checkingRequests($keeper);
                }
                $reserveList = $this->reserveController->loadDoneReservesList($keeper->getIdKeeper());
                require_once(VIEWS_PATH . "keeper-reserve.php");
        }
    
        public function ShowModifyAvailabilityView($message = "") {
            require_once(VIEWS_PATH . "validate-session.php");
            $keeper = $this->keeperDAO->getByIdUser(($_SESSION["loggedUser"]->getId()));
            $boolean = $this->checkingRequests($keeper);
            $array = $this->reserveController->checkingReserves($keeper);
            require_once(VIEWS_PATH . "keeper-modify-availability.php");
        }

        public function Add($adress, $initDate, $finishDate, $daysToWork, $petSizeToKeep, $priceToKeep, $petsAmount){ 
            require_once(VIEWS_PATH . "validate-session.php");
            $areDatesOk = $this->checkingDates($initDate, $finishDate, $daysToWork);
            if($areDatesOk){
                $keeper = new Keeper();
                $keeper = $this->loadKeeper($adress, $initDate, $finishDate, $daysToWork,$petSizeToKeep, $priceToKeep, $petsAmount);

                $keeper->setIdKeeper($this->keeperDAO->Add($keeper));
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
            $areDatesOk = $this->checkingDates($initDate, $lastDate, $daysToWork);
            if($areDatesOk){

            $keeper = new Keeper();
            $keeper = $this->loadKeeper($adress, $initDate, $lastDate, $daysToWork,$petSizeToKeep, $priceToKeep, $petsAmount);
            $keeper->setIdKeeper(intval($idKeeper));

            $keepersReserveList = $this->reserveController->loadAllReservesFromKeeper($keeper->getIdKeeper());
            foreach($keepersReserveList as $reserve){ //elimino cada reserva que tenia el keeper por el id
                $this->invoiceController->invoiceDAO->RemoveByReserveId($reserve->getId());
                $this->reserveController->reserveDAO->Remove($reserve->getId()); //para poder modificar la disponibilidad y al keeper, foreign keys.. 
            }
            $this->availabilityController->Modify($keeper, $initDate, $lastDate, $daysToWork);
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
            $reserveRequestList = $this->reserveController->reserveDAO->GetAll();

            if(is_array($reserveRequestList)){
                foreach($reserveRequestList as $reserve){
                $availabilityAux = $this->availabilityController->availabilityDAO->GetById($reserve->getAvailability()->getId());
                
                if($availabilityAux->getKeeper()->getIdKeeper() == $keeper->getIdKeeper() && $reserve->getIsActive() == 1){
                    $petAux = $this->petController->petDAO->GetById($reserve->getPet()->getId_Pet());
                        $reserveToReturn["availabilityId"] = $availabilityAux->getId();
                        $reserveToReturn["reserveId"] = $reserve->getId();
                        $reserveToReturn["date"] = $availabilityAux->getDate();
                        $reserveToReturn["pet"] = $petAux;
                        array_push($arrayToReturn, $reserveToReturn);
                    }
                }
            }else{
                if($reserveRequestList){
                    $availabilityAux = $this->availabilityController->availabilityDAO->GetById($reserveRequestList->getAvailability()->getId());
                    if($availabilityAux->getKeeper()->getIdKeeper() == $keeper->getIdKeeper() && $reserveRequestList->getIsActive() == 1){
                        $petAux = $this->petController->petDAO->GetById($reserveRequestList->getPet()->getId_Pet());
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

        public function checkingRequests($keeper){
            $boolean = false;
            $reserveRequestList = $this->reserveController->reserveDAO->GetAll();

            if(is_array($reserveRequestList)){
                foreach($reserveRequestList as $reserve){
                    if($reserve->getIsActive()==1){
                        $availabilityAux = $this->availabilityController->availabilityDAO->GetById($reserve->getAvailability()->getId());

                        if($keeper->getIdKeeper() == $availabilityAux->getKeeper()->getIdKeeper()){
                            $boolean = true;
                        }
                    }
                }
            }elseif($reserveRequestList){
                if($reserveRequestList->getIsActive()==1){
                $availabilityAux = $this->availabilityController->availabilityDAO->GetById($reserveRequestList->getAvailability()->getId());
                if($keeper->getIdKeeper() == $availabilityAux->getKeeper()->getIdKeeper()){
                    $boolean = true;
                    }
                }
            }
            return $boolean;
        }

        public function checkingReserveRedundancy(Reserve $reserve){
            $availabilityToConfirm = $this->availabilityController->availabilityDAO->GetById($reserve->getAvailability()->getId());
            $keeperFromReserveToConfirm = $this->keeperDAO->GetById($availabilityToConfirm->getKeeper()->getIdKeeper());
            $boolean = true;
    
            $reservesList = $this->reserveController->reserveDAO->GetAll();
            if(is_array($reservesList)){
               
                foreach($reservesList as $doneReserves){
                if($doneReserves->getIsActive()==0){ //valido que sean reservas ya aceptadas
                $availabilityAux = $this->availabilityController->availabilityDAO->GetById($doneReserves->getAvailability()->getId());
                $keeperRConfirmed = $this->keeperDAO->GetById($availabilityAux->getKeeper()->getIdKeeper());
                
                if($availabilityAux->getDate() == $availabilityToConfirm->getDate() && $keeperRConfirmed->getIdKeeper() == $keeperFromReserveToConfirm->getIdKeeper()){
                    if($doneReserves->getPet()->getId_Pet() == $reserve->getPet()->getId_Pet()){
                        $boolean = false;
                        }
                    }
                    }
                }
            }
            
            return $boolean;
        }

        public function modifyingReserve($date, $petName, $petType, $userName, $petId, $availabilityId, $reserveId, $value){
            
            $keeper = $this->keeperDAO->GetByIdUser($_SESSION["loggedUser"]->getId());
            $availability = $this->availabilityController->availabilityDAO->GetById($availabilityId);
            $petAux = $this->petController->petDAO->GetById($petId);
            
            if($value==1){
                $this->confirmingReserve($keeper, $availability, $petAux, $reserveId);
            }elseif($value==2){
                $this->cancelingReserve($keeper, $availability, $petAux, $reserveId);
            }
        }

        public function cancelingReserve($keeper, $availability, $pet, $reserveId){

            $this->reserveController->reserveDAO->Remove($reserveId);
            $message = 'Reserve successfully rejected!';
            $this->ShowPendingReserves($message);
        }

        public function confirmingReserve($keeper, $availability, $pet, $reserveId){

            $reserve = $this->reserveController->reserveDAO->GetById($reserveId);
            $reserve->setIsActive(0);

            $user = $this->userDAO->GetById($pet->getId_User()->getId());

            $doesPetAlreadyMadeAReserve = $this->checkingReserveRedundancy($reserve);
            $isReserveDayFullLoaded =  $this->reserveController->checkingReservesAmount($keeper, $availability->getId());
            $isPetTypeWellLoaded = $this->reserveController->validatePetType($reserve, $keeper);

            if($doesPetAlreadyMadeAReserve && $isReserveDayFullLoaded && $isPetTypeWellLoaded){

                $this->reserveController->reserveDAO->Modify($reserve); //al confirmar modifica el estado de la reserva
                $isReserveDayFullLoaded = $this->reserveController->checkingReservesAmount($keeper, $availability->getId());
                
                if(!$isReserveDayFullLoaded){ //si el keeper tiene ese dia completo, se anula la disponibilidad de esa fecha
                    $availability->setAvailable(0);
                    $this->availabilityController->availabilityDAO->Modify($availability);
                }
                $this->invoiceController->Add($reserve);
                $this->emailController->sendPaymentCoupon($user, $reserve, null);
                
                $message = "DONE! Accepted reserve";
                $this->ShowPendingReserves($message);
            }else{
                if(!$doesPetAlreadyMadeAReserve){
                    $message = "ERROR: You've already accepted this pet on that date.";
                }elseif(!$isReserveDayFullLoaded){
                    $message = "ERROR: the date is already full";
                }elseif(!$isPetTypeWellLoaded){
                    $message = "ERROR: you can only accept another pet of the same type";
                }
                $this->ShowPendingReserves($message);
            }
        }

    }
?>