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

        public function __construct()
        {
            $this->userDAO = new UserDAO();
            $this->userTypeDAO = new UserTypeDAO();
        }

        public function ShowAddView()
        {
            $userTypeList = $this->userTypeDAO->GetAll();

            require_once(VIEWS_PATH."add-user.php");
        }

        public function ShowListView()
        {
            $userList = $this->userDAO->GetAll();
            $userTypeList = $this->userTypeDAO->GetAll();

            foreach($userList as $user)
            {
                $userTypeId = $user->getUserType()->getId();
                $userTypes = array_filter($userTypeList, function($userType) use($userTypeId){                    
                    return $userType->getId() == $userTypeId;
                });

                $userTypes = array_values($userTypes); //Reordering array

                $userType = (count($userTypes) > 0) ? $userTypes[0] : new UserType(); //If beerType does not exist, we create an empty object to avid null reference

                $user->setBeerType($userType);
            }
            
            require_once(VIEWS_PATH."user-list.php");
        }

        public function Add($firstname,$lastname,$dni,$email,$phone,$userTypeId,$username,$password)
        {
            $userType = new UserType();
            $userType->setId($userTypeId);
                        
            $user = new User();
            $user->setUserType($userType);
            $user->setFirstName($firstname);
            $user->setLastName($lastname);
            $user->setDni($dni);
            $user->setEmail($email);
            $user->setPhoneNumber($phone);
            $user->setUserName($username);
            $user->setPassword($password);
            

            $this->userDAO->Add($user);

            $this->ShowAddView();
        }

        public function Remove($dni)
        {
            $this->userDAO->Remove($dni);            

            $this->ShowListView();
        }
    }
?>