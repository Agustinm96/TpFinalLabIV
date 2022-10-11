<?php

    namespace DAO;

    use Models\Owner;

    class OwnerDAO implements IOwnerDAO {
        private $fileName = ROOT . "/Data/owners.json";
        private $ownersList = array();

        public function Add($owner) {
            $this->RetrieveData();

            $owner->setIdOwner($this->GetNextId());

            array_push($this->ownersList, $owner);

            $this->SaveData();
        }

        public function Remove($idOwner) {
            $this->RetrieveData();

            $this->ownersList = array_filter($this->ownersList, function($owner) use($idOwner) {
                return $owner->getIdOwner() != $idOwner;
            });

            $this->SaveData();
        }

        public  function GetAll() {
            $this->RetrieveData();
            return $this->ownersList;
        }

        public function GetById($id) {
            $this->RetrieveData();

            $aux = array_filter($this->ownersList, function($owner) use($id) {
                return $owner->getIdOwner() == $id;
            });

            $aux = array_values($aux);

            return (count($aux) > 0) ? $aux[0] : null;
        }

        private function SaveData() {
            $arrayEncode = array();

            foreach($this->ownersList as $owner) {
                
                $value["firstName"] = $owner->getFirstName();
                $value["lastName"] = $owner->getLastName();
                $value["dni"] = $owner->getDni();
                $value["email"] = $owner->getEmail();
                $value["phoneNumber"] = $owner->getPhoneNumber();
                $value["idOwner"] = $owner->getIdOwner();
                $value["username"] = $owner->getUsername();
                $value["password"] = $owner->getPassword();

                array_push($arrayEncode, $value);
            }

            $jsonContent = json_encode($arrayEncode, JSON_PRETTY_PRINT);
            file_put_contents($this->fileName, $jsonContent);
        }

        private function RetrieveData() {
            $this->ownersList = array();

            if(file_exists($this->fileName)) {
                $jsonContent = file_get_contents($this->fileName);
                $arrayDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayDecode as $value) {
                    $owner = new Owner();
                    $owner->setFirstName($value["firstName"]);
                    $owner->setLastName($value["lastName"]);
                    $owner->setDni($value["dni"]);
                    $owner->setEmail($value["email"]);
                    $owner->setPhoneNumber($value["phoneNumber"]);
                    $owner->setIdOwner($value["idOwner"]);
                    $owner->setUsername($value["username"]);
                    $owner->setPassword($value["password"]);

                    array_push($this->ownersList, $owner);
                }
            }
        }

        private function GetNextId() {
            $id = 0;

            foreach($this->ownersList as $owner) {
                $id = ($owner->getIdKeeper() > $id) ? $owner->getIdOwner() : $id;
            }

            return $id + 1;
        }
    }
?>