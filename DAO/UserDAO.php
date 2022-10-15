<?php
    namespace DAO;

    use DAO\IUserDAO;
    use Models\User;
    use Models\UserType;

    class UserDAO implements IUserDAO
    {
        private $userList = array();
        private $fileName = ROOT."Data/users.json";

        function Add(User $user)
        {
            $this->RetrieveData();

            $user->setId($this->GetNextId());

            array_push($this->userList, $user);

            $this->SaveData();
        }

        function GetAll()
        {
            $this->RetrieveData();

            return $this->userList;
        }

        function GetByDNI($dni)
        {
            $this->RetrieveData();

            $user = array_filter($this->userList, function($user) use($dni){
                return $user->getDni() == $dni;
            });

            $users = array_values($user); //Reorderding array

            return (count($users) > 0) ? $users[0] : null;
        }

        function Remove($id)
        {
            $this->RetrieveData();

            $this->userList = array_filter($this->userList, function($user) use($id){
                return $user->getId() != $id;
            });

            $this->SaveData();
        }

        private function RetrieveData()
        {
             $this->userList = array();

             if(file_exists($this->fileName))
             {
                 $jsonToDecode = file_get_contents($this->fileName);

                 $contentArray = ($jsonToDecode) ? json_decode($jsonToDecode, true) : array();
                 
                 foreach($contentArray as $content)
                 {
                     $userType = new UserType();                     
                     $userType->setId($content["userTypeId"]);

                     $user = new User();
                     $user->setId($content["id"]);
                     $user->setUserType($userType);
                     $user->setFirstName($content["firstName"]);                       
                     $user->setLastName($content["lastName"]);
                     $user->setDni($content["dni"]);
                     $user->setEmail($content["email"]);
                     $user->setPhoneNumber($content["phoneNumber"]);                     
                     $user->setUserName($content["username"]);
                     $user->setPassword($content["password"]);

                     array_push($this->userList, $user);
                 }
             }
        }

        private function SaveData()
        {
            $arrayToEncode = array();

            foreach($this->userList as $user)
            {
                $valuesArray = array();
                $valuesArray["id"] = $user->getId();
                $valuesArray["userTypeId"] = $user->getUserType()->getId();
                $valuesArray["firstName"] = $user->getFirstName();
                $valuesArray["lastName"] = $user->getLastName();
                $valuesArray["dni"] = $user->getDni();
                $valuesArray["email"] = $user->getEmail();
                $valuesArray["phoneNumber"] = $user->getPhoneNumber();
                $valuesArray["username"] = $user->getUsername();
                $valuesArray["password"] = $user->getPassword();
                array_push($arrayToEncode, $valuesArray);
            }

            $fileContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

            file_put_contents($this->fileName, $fileContent);
        }

        private function GetNextId()
        {
            $id = 0;

            foreach($this->userList as $user)
            {
                $id = ($user->getId() > $id) ? $user->getId() : $id;
            }

            return $id + 1;
        }

        public function GetByUserName($userName)
        {
            $user = null;

            $this->RetrieveData();

            $users = array_filter($this->userList, function($user) use($userName){
                return $user->getUserName() == $userName;
            });

            $users = array_values($users); //Reordering array indexes

            return (count($users) > 0) ? $users[0] : null;
        }

        public function GetByEmail($email)
        {
            $user = null;

            $this->RetrieveData();

            $users = array_filter($this->userList, function($user) use($email){
                return $user->getEmail() == $email;
            });

            $users = array_values($users); //Reordering array indexes

            return (count($users) > 0) ? $users[0] : null;
        }

    }

?>