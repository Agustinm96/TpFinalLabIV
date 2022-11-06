<?php

namespace Controllers;

use DAO\UserDAO as UserDAO;
use DAO\OwnerDAO;
use DAO\PetDAO;
use DAO\KeeperDAO;
use Models\Owner;
use Models\User as User;
use Models\Pet;
use Models\Keeper;
use Models\Dog;
use Models\Cat;
use Models\PetType;
use Models\ReserveRequest;

class OwnerController
{
    private $ownerDAO;
    private $userDAO;
    private $keeperController;
    private $petController;
    private $availabilityController;
    private $reserveRequestController;

    public function __construct()
    {
        $this->ownerDAO = new OwnerDAO();
        $this->userDAO = new UserDAO();
        $this->keeperController = new KeeperController();
        $this->petController  = new PetController();
        $this->availabilityController = new AvailabilityController();
        $this->reserveRequestController = new ReserveRequestController();
    }

    public function ShowHomeView($message = "")
    {
        //require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "home.php");
    }

    public function ShowAddView($message = "")
    {
        //require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "home.php");
    }

    public function ShowListView()
    {
        require_once(VIEWS_PATH . "validate-session.php");
        $ownersList = $this->ownerDAO->GetAll();

        require_once(VIEWS_PATH . "owners-list.php");
    }

    public function ShowLoadReserveView($id, $message = ""){
        require_once(VIEWS_PATH . "validate-session.php");
        $keeper = $this->keeperController->keeperDAO->GetById($id);
        $petList = $this->petController->petDAO->GetByUserName($_SESSION["loggedUser"]->GetUserName());
        require_once(VIEWS_PATH . "load-reserve.php");
    }

    public function ShowAskForAKeeper($message = "")
    {
        require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "loading-dates.php");
    }

    public function ShowMyProfile(){  
        require_once(VIEWS_PATH . "validate-session.php");
        $owner = $this->ownerDAO->getByIdUser(($_SESSION["loggedUser"]->getId()));
        require_once(VIEWS_PATH . "owner-profile.php");
    }

    public function ShowGenerateReserveView($id, $message="")
    {
        require_once(VIEWS_PATH . "validate-session.php");
        $keeper = $this->keeperController->keeperDAO->GetById($id);
        $availabilityList = $this->availabilityController->availabilityDAO->GetByIdKeeper($keeper->getIdKeeper());
        $petList = $this->petController->petDAO->GetByUserName($_SESSION["loggedUser"]->GetUserName());
        require_once(VIEWS_PATH . "load-reserve.php");
    }

    public function Add($adress)
    {
        require_once(VIEWS_PATH . "validate-session.php");
        $user = new User();
        $user=($_SESSION["loggedUser"]);

        $owner = new Owner();
        $owner->setUser($user);
        $owner->setAdress($adress);

        $this->ownerDAO->Add($owner);

        $message = 'Profile succesfully completed!';

        $this->ShowHomeView($message);
    }

    public function Remove($idUser)
    {
        $this->ownerDAO->Remove($idUser);
        $this->userDAO->Remove($idUser);
        $this->ShowListView();
    }

    public function generatingReserve($date, $petList, $keeperId){
        
        $keeper = new Keeper();
        $keeper = $this->keeperController->keeperDAO->GetById($keeperId);
        $availabilityList = $this->availabilityController->availabilityDAO->GetByIdKeeper($keeperId);

        foreach($availabilityList as $availability){
            if($availability->getDate() == $date){

                $petArray = $this->loadingPetsArray($petList); //para validar el tipo y tamaño de mascota
                $boolean2 = $this->checkingPetType($petArray);
                $boolean3 = $this->checkingPetSize($petArray, $keeper);

                $boolean1 = $this->checkingPetListRedundancy($availability,$petList); //para validar carga de datos repetidos, ej. si ya cargo la pet antes
            
                if($boolean1 && $boolean2 && $boolean3){
                    
                    foreach($petList as $pet){
                        $reserveRequest = new ReserveRequest();
                        $reserveRequest->setAvailabilityId($availability->getId()); //le asigno la id de la disponibilidad
                        $reserveRequest->setPetId($pet);
                        $this->reserveRequestController->reserveRequestDAO->Add($reserveRequest);
                    }
    
                    $message = 'Reservation successfully made';
                    $this->ShowHomeView($message); 
                }else{
                    if(!$boolean1){
                        $message = "ERROR: You've already request a reserve for this pet";
                    }
                    if(!$boolean2){
                        $message = "ERROR: You can only choose one pet type, either dog or cat.";
                    }else if(!$boolean3){
                        $message = "ERROR: The size of your pet doesn't match what the keeper can handle!";
                    }
                    $this->ShowGenerateReserveView($keeperId, $message);
                    }
                }
        }
    }

    public function checkingPetListRedundancy($availability, $petList_loaded){
        $reserveRequestList = $this->reserveRequestController->reserveRequestDAO->GetAll();
        $boolean = true;

        foreach($reserveRequestList as $reserveRequest){
            $availabilityAux = $this->availabilityController->availabilityDAO->GetById($reserveRequest->getAvailabilityId());
            if($availability->getDate() == $availabilityAux->getDate() && $availabilityAux->getIdKeeper() == $availability->getIdKeeper()){
                foreach($petList_loaded as $pet){
                    if($reserveRequest->getPetId() == $pet){
                        $boolean = false;
                        }
                    }
                }
            }
        return $boolean;
    }

    public function checkingPetSize($petsArray, $keeper){
        $boolean = false;
        
        foreach($petsArray as $pet){
            if($pet->getPetType()->getPetTypeId()==1){//if cat return true (doesnt check size), else: checks size..
                $boolean = true;
            }else{
                    if($pet->getSize() == $keeper->getPetSizeToKeep()){
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
            if($pet->getPetType()->getPetTypeId()==0){
                $dogCounter++;
            }else if($pet->getPetType()->getPetTypeId()==1){
                $catCounter++;
            }
        }
        if($dogCounter>=1 && $catCounter>=1){
            return false;
        }else{
            return true;
        }

    }

    public function loadingPetsArray($petList){
        $arrayPets = array();
        foreach($petList as $pet){
            $petAux = $this->petController->petDAO->GetById($pet);
            
            if($petAux->getPetType()->getPetTypeId()==0){
                
                $dog = new Dog();
                $dog = $this->petController->petDAO->GetById($petAux->getIDPET());
                array_push($arrayPets, $dog);
            }else if($petAux->getPetType()->getPetTypeId()==1){
                $cat = new Cat();
                $cat = $this->petController->petDAO->GetById($petAux->getIDPET());
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
}
