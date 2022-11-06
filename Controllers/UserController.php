<?php
    namespace Controllers;

    use DAO\UserDAO;
    use DAO\UserTypeDAO; 
    use Models\User;
    use Models\UserType;

    class UserController
    {
        private $userDAO;
        private $userTypeDAO;
        private $keeperController;

        public function __construct()
        {
            $this->userDAO = new UserDAO();
            $this->userTypeDAO = new UserTypeDAO();
            $this->keeperController = new KeeperController();
        }

        public function ShowAddView($message="",$userType=null)
        {
            $userTypeList = $this->userTypeDAO->GetAll();
            if($userType==1){
                require_once(VIEWS_PATH."profile-completion-owner.php");
            }else if($userType==2){
                require_once(VIEWS_PATH."profile-completion-keeper.php");
            }else if($userType==3){
                require_once(VIEWS_PATH."home.php");
            }
            else{
                require_once(VIEWS_PATH."add-user.php");
            }
        }

        public function ShowListView()
        {
            $userList = $this->userDAO->GetAll();
            
            require_once(VIEWS_PATH."user-list.php");
        }

        public function ShowHomeView($idType, $message=""){
            if($idType==1 || $idType==2){
                require_once(VIEWS_PATH."home.php");
            }elseif($idType==3){
                require_once(VIEWS_PATH."admin.php");
            }
        }

        public function ShowMyProfile(){  
            require_once(VIEWS_PATH . "validate-session.php");
            $user = $_SESSION["loggedUser"];
            if($user->getUserType()->getId()==2){
                $keeper = $this->keeperController->keeperDAO->GetByIdUser($user->getId());
                $boolean = $this->keeperController->checkingRequests($keeper);
            }
            require_once(VIEWS_PATH . "profile-view.php");
        }

        public function ShowModifyProfileView($message="") {
            require_once(VIEWS_PATH . "validate-session.php");
            $user = ($_SESSION["loggedUser"]);
            require_once(VIEWS_PATH . "modify-profile.php");
        }

        public function Add($firstname,$lastname,$dni,$email,$phone,$userTypeId,$username,$password)
        {
            $userType = new UserType();
            $userType = $this->userTypeDAO->GetById($userTypeId);
                        
            $user = new User();
            $user->setUserType($userType);
            $user->setFirstName($firstname);
            $user->setLastName($lastname);
            $user->setDni($dni);
            $user->setEmail($email);
            $user->setPhoneNumber($phone);
            $user->setUserName($username);
            $user->setPassword($password);
            
            if($this->userDAO->GetByUserName($user->getUsername())){
                $this->ShowAddView("Ya existe un usuario con ese Username",null);
            }elseif($this->userDAO->getByDNI($user->getDni())){
                $this->ShowAddView("Ya existe un usuario con ese DNI",null);
            }elseif($this->userDAO->GetByEmail($user->getEmail())){
                $this->ShowAddView("Ya existe un usuario con ese Email",null); 
            }
            else{
                $user->setId($this->userDAO->Add($user));
                $_SESSION["loggedUser"]=$user;
                $this->ShowAddView("",$user->getUserType()->getId());
            }

        }

        public function ModifyProfile($name, $lastName, $email, $phoneNumber, $userName, $password) {
            require_once(VIEWS_PATH . "validate-session.php");

            $user = new User();
            $user = ($_SESSION["loggedUser"]);

            $user->setFirstName(ucfirst($name));
            $user->setLastName(ucfirst($lastName));
            $user->setEmail($email); 
            $user->setPhoneNumber($phoneNumber);
            $user->setUserName($userName);
            $user->setPassword($password);

            $this->userDAO->Modify($user);
            
            $message = 'Profile succesfully updated!';
            
            $this->ShowHomeView($user->getUserType()->getId(),$message);
            
        }

        public function Remove($id)
        {
            $this->userDAO->Remove($id);            

            $this->ShowListView();
        }
    }
?>