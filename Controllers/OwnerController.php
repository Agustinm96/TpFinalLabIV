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
use Models\Reserve;

class OwnerController
{
    public $ownerDAO;
    private $userDAO;
    private $keeperController;
    private $petController;
    private $availabilityController;
    private $reserveController;
    private $invoiceController;

    public function __construct()
    {
        $this->ownerDAO = new OwnerDAO();
        $this->userDAO = new UserDAO();
        $this->keeperController = new KeeperController();
        $this->petController  = new PetController();
        $this->availabilityController = new AvailabilityController();
        $this->reserveController = new ReserveController();
        $this->invoiceController = new InvoiceController();
    }

    public function ShowHomeView($message = "")
    {
        require_once(VIEWS_PATH . "validate-session.php");
        $owner = $this->ownerDAO->GetByIdUser(($_SESSION["loggedUser"]->getId()));
        $ownerBoolean = $this->checkingIfAreInvoicesToPay($owner);
        require_once(VIEWS_PATH . "home.php");
    }

    public function ShowAddView($message = "")
    {
        //require_once(VIEWS_PATH . "validate-session.php");
        $owner = $this->ownerDAO->GetByIdUser(($_SESSION["loggedUser"]->getId()));
        $ownerBoolean = $this->checkingIfAreInvoicesToPay($owner);
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
        $owner = $this->ownerDAO->GetByIdUser(($_SESSION["loggedUser"]->getId()));
        $ownerBoolean = $this->checkingIfAreInvoicesToPay($owner);
        require_once(VIEWS_PATH . "loading-dates.php");
    }

    public function ShowPetAddViewFromOwner() {
        require_once(VIEWS_PATH . "validate-session.php");
        $owner = $this->ownerDAO->GetByIdUser(($_SESSION["loggedUser"]->getId()));
        $ownerBoolean = $this->checkingIfAreInvoicesToPay($owner);
        require_once(VIEWS_PATH . "add-choice.php");
    }

    public function ShowPerfilViewFromOwner($message = ""){
        require_once(VIEWS_PATH . "validate-session.php");
        $petList = $this->petController->petDAO->GetById_User($_SESSION["loggedUser"]->GetId());
       // var_dump($petList);
        $owner = $this->ownerDAO->GetByIdUser(($_SESSION["loggedUser"]->getId()));
        $ownerBoolean = $this->checkingIfAreInvoicesToPay($owner);
        require_once(VIEWS_PATH . "perfil-petlist.php");
    }

    public function ShowUploadVideoFromOwner($PETID) {
        require_once(VIEWS_PATH . "validate-session.php");
        $PETID = $PETID;
        $owner = $this->ownerDAO->GetByIdUser(($_SESSION["loggedUser"]->getId()));
        $ownerBoolean = $this->checkingIfAreInvoicesToPay($owner);
        require_once(VIEWS_PATH . "video-files.php");
    }

    public function ShowUploadPetVaccinationFromOwner($PETID) {
        require_once(VIEWS_PATH . "validate-session.php");
        $PETID = $PETID;
        $owner = $this->ownerDAO->GetByIdUser(($_SESSION["loggedUser"]->getId()));
        $ownerBoolean = $this->checkingIfAreInvoicesToPay($owner);
        require_once(VIEWS_PATH . "vaccination-files.php");
    }
    public function ShowUploadPetPictureFromOwner($PETID) {
        require_once(VIEWS_PATH . "validate-session.php");
        $PETID = $PETID;
        $owner = $this->ownerDAO->GetByIdUser(($_SESSION["loggedUser"]->getId()));
        $ownerBoolean = $this->checkingIfAreInvoicesToPay($owner);
        require_once(VIEWS_PATH . "picture-files.php");
    }

    public function ShowInvoicePayment($userName,$password,$receiveId)
    {
        require_once(VIEWS_PATH . "validate-session.php");
        $invoice = $this->invoiceController->invoiceDAO->GetByIdReserve($receiveId);
        $reserve = $this->reserveController->reserveDAO->GetById($receiveId);
        $availability = $this->availabilityController->availabilityDAO->GetById($reserve->getAvailability()->getId());
        require_once(VIEWS_PATH . "invoice-payment.php");
    }

    public function ShowInvoicePaymentFromPage($invoiceId, $petName, $date, $price)
    {
        require_once(VIEWS_PATH . "validate-session.php");
        $invoice = $this->invoiceController->invoiceDAO->GetById($invoiceId);
        $reserve = $this->reserveController->reserveDAO->GetById($invoice->getReserve()->getId());
        $availability = $this->availabilityController->availabilityDAO->GetById($reserve->getAvailability()->getId());
        require_once(VIEWS_PATH . "invoice-payment.php");
    }

    public function ShowInvoicesToPay(){
        require_once(VIEWS_PATH . "validate-session.php");
        $owner = $this->ownerDAO->GetByIdUser(($_SESSION["loggedUser"]->getId()));
        $ownerBoolean = $this->checkingIfAreInvoicesToPay($owner);
        $invoicesToPayList = $this->loadingInvoicesToPay($owner);
        require_once(VIEWS_PATH . "invoicesToPay-list.php");
    }

    public function ShowMyProfile(){  
        require_once(VIEWS_PATH . "validate-session.php");
        $owner = $this->ownerDAO->GetByIdUser(($_SESSION["loggedUser"]->getId()));
        $ownerBoolean = $this->checkingIfAreInvoicesToPay($owner);
        require_once(VIEWS_PATH . "owner-profile.php");
    }

    public function ShowAvailableListView($initDate, $lastDate){
        require_once(VIEWS_PATH . "validate-session.php");   
        $availabilityList = $this->availabilityController->availabilityDAO->GetAll();
        
        if($_SESSION["loggedUser"]->getUserType()->getId()==1){
            $owner = $this->ownerDAO->GetByIdUser(($_SESSION["loggedUser"]->getId()));
            $ownerBoolean = $this->checkingIfAreInvoicesToPay($owner);
        }

        if($initDate <= $lastDate){
            $keepersList = $this->keeperController->keeperDAO->getAvailableKeepersByDates($availabilityList, $initDate, $lastDate);

            require_once(VIEWS_PATH . "keepers-list.php");
        }else{
            $message = "ERROR: The dates you selected are invalid! Please select them again";
            require_once(VIEWS_PATH . "loading-dates.php");
        }
        
    }

    public function ShowGenerateReserveView($id, $message="")
    {
        require_once(VIEWS_PATH . "validate-session.php");
        $owner = $this->ownerDAO->GetByIdUser(($_SESSION["loggedUser"]->getId()));
        $ownerBoolean = $this->checkingIfAreInvoicesToPay($owner);

        $keeper = $this->keeperController->keeperDAO->GetById($id);
        $availabilityList = $this->availabilityController->availabilityDAO->GetByIdKeeper($keeper->getIdKeeper());
        
        $petList = $this->petController->petDAO->GetById_User($_SESSION["loggedUser"]->getId());
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

        $keeper = $this->keeperController->keeperDAO->GetById($keeperId);
        $availabilityList = $this->availabilityController->availabilityDAO->GetByIdKeeper($keeperId);

        foreach($availabilityList as $availability){
            if($availability->getDate() == $date){

                $petArray = $this->loadingPetsArray($petList); //para validar el tipo y tamaño de mascota
                $isPetTypeWellLoaded = $this->checkingPetType($petArray);
                $isPetSizeOkWithKeeper = $this->checkingPetSize($petArray, $keeper);

                $doesPetAlreadyMadeARequest = $this->checkingPetListRedundancy($availability,$petList); //para validar carga de datos repetidos, ej. si ya cargo la pet antes
                
                if($isPetTypeWellLoaded && $isPetSizeOkWithKeeper && $doesPetAlreadyMadeARequest){
                    
                    foreach($petArray as $pet){
                        $reserve = new Reserve();
                        $reserve->setAvailability($availability); //le asigno la id de la disponibilidad
                        $reserve->setPet($pet);
                        $reserve->setIsActive(1);
                        $this->reserveController->reserveDAO->Add($reserve);
                    }
    
                    $message = 'Reservation successfully made';
                    $this->ShowHomeView($message); 
                }else{
                    if(!$doesPetAlreadyMadeARequest){
                        $message = "ERROR: You've already request a reserve for this pet";
                    }
                    if(!$isPetTypeWellLoaded){
                        $message = "ERROR: You can only choose one pet type, either dog or cat.";
                    }else if(!$isPetSizeOkWithKeeper){
                        $message = "ERROR: The size of your pet doesn't match what the keeper can handle!";
                    }
                    $this->ShowGenerateReserveView($keeperId, $message);
                    }
                }
        }
    }

    public function checkingPetListRedundancy($availability, $petList_loaded){
        $reserveRequestList = $this->reserveController->reserveDAO->GetAll(); //puede devolver un objeto o un arreglo dependiendo si es un elemento o + de 1
        $boolean = true;

        if(is_array($reserveRequestList)){ 
            foreach($reserveRequestList as $reserveRequest){
            $availabilityAux = $this->availabilityController->availabilityDAO->GetById($reserveRequest->getAvailability()->getId());
            if($availability->getDate() == $availabilityAux->getDate() && $availabilityAux->getKeeper()->getIdKeeper() == $availability->getKeeper()->getIdKeeper()){
                foreach($petList_loaded as $pet){
                    if($reserveRequest->getPet()->getId_Pet() == $pet){
                        $boolean = false;
                        }
                    }
                }
            }
        }elseif($reserveRequestList){
            $availabilityAux = $this->availabilityController->availabilityDAO->GetById($reserveRequestList->getAvailability()->getId());
            if($availability->getDate() == $availabilityAux->getDate() && $availabilityAux->getKeeper()->getIdKeeper() == $availability->getKeeper()->getIdKeeper()){
            foreach($petList_loaded as $pet){
                    if($reserveRequestList->getPet()->getId_Pet() == $pet){
                        $boolean = false;
                        }
                    }
            }
        }
        return $boolean;
    }

    public function checkingPetSize($petsArray, $keeper){
        $boolean = true;
        
        foreach($petsArray as $pet){
            if($pet->getPetType()->getPetTypeId()==1){//if cat return true (doesnt check size), else: checks size..
                    if($pet->getSize() != $keeper->getPetSizeToKeep()){
                    $boolean = false;
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
            if($pet->getPetType()->getPetTypeId()==1){
                $dogCounter++;
            }else if($pet->getPetType()->getPetTypeId()==2){
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
            
            if($petAux->getPetType()->getPetTypeId()==1){
                $dog = new Dog();
                $dog = $this->petController->petDAO->GetById($petAux->getId_Pet());
                array_push($arrayPets, $dog);
            }else if($petAux->getPetType()->getPetTypeId()==2){
                $cat = new Cat();
                $cat = $this->petController->petDAO->GetById($petAux->getId_Pet());
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

    public function PayInvoice($invoiceId){
        
        $invoice = $this->invoiceController->invoiceDAO->GetById($invoiceId);
        
        if($invoice->getIsPayed() == 0){
            $message = "ERROR. You've already payed the invoice";
        }else{
            $invoice->setIsPayed(1);
            $this->invoiceController->invoiceDAO->Modify($invoice);
            $message = "Invoice successfully payed. Thank You";
        }

        $this->ShowHomeView($message);
    }

    public function checkingIfAreInvoicesToPay($owner){
        $invoicesList = $this->invoiceController->invoiceDAO->GetAll();
        $boolean = false;
  if(is_object($owner)){  //parche momentaneo
        if(is_array($invoicesList)){
            foreach($invoicesList as $invoice){
            if($invoice->getReserve()->getPet()->getId_User()->getId() == $owner->getUser()->getId()){ 
                //comprueba que invoice sea de el owner ingresado por param
                if($invoice->getIsPayed()=='0'){
                    $boolean = true;
                    }
                }
            }
        }elseif($invoicesList){
            if($invoicesList->getReserve()->getPet()->getId_User()->getId() == $owner->getUser()->getId()){ 
                //comprueba que invoice sea de el owner ingresado por param
                if($invoicesList->getIsPayed()=='0'){
                    $boolean = true;
                    }
                }
            }
        return $boolean;
  }else{
    return $boolean;
  }
    }

    public function loadingInvoicesToPay($owner){
        $invoicesList = $this->invoiceController->invoiceDAO->GetAll();
        $arrayToReturn=array();

        if(is_array($invoicesList)){
        foreach($invoicesList as $invoice){
            if($invoice->getReserve()->getPet()->getId_User()->getId() == $owner->getUser()->getId()){ 
                //comprueba que invoice sea de el owner ingresado por param
                if($invoice->getIsPayed()==0){
                    array_push($arrayToReturn, $invoice);
                }
            }
        }
       
    }elseif($invoicesList){
        if($invoicesList->getReserve()->getPet()->getId_User()->getId() == $owner->getUser()->getId()){ 
            //comprueba que invoice sea de el owner ingresado por param
            if($invoicesList->getIsPayed()==0){
                array_push($arrayToReturn, $invoicesList);
                }
            }
        } 
        return $arrayToReturn;
    }
}
