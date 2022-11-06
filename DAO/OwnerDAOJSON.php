<?php

    namespace DAO;

    use Models\Owner;
    use Models\User;

    class OwnerDAOJSON implements IOwnerDAO {
        private $fileName = ROOT . "/Data/owners.json";
        private $ownersList = array();

        public function Add($owner) {
            $this->RetrieveData();

            $owner->setIdOwner($this->GetNextId());

            array_push($this->ownersList, $owner);

            $this->SaveData();
        }

        public function Remove($idUser) {
            $this->RetrieveData();

            $this->ownersList = array_filter($this->ownersList, function($owner) use($idUser) {
                return $owner->getUser()->getId() != $idUser;
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

        public function GetByUserName($userName){
        $this->RetrieveData();

        $aux = array_filter($this->ownersList, function($owner) use($userName){
            return $owner->getUserName() == $userName;
        });

        $aux = array_values($aux); //Reorderding array

        return (count($aux) > 0) ? $aux[0] : null;

    }

        public function GetByIdUser($idUser) {
            $this->RetrieveData();

            $aux = array_filter($this->ownersList, function($owner) use($idUser) {
                return $owner->getUser()->getId() == $idUser;
            });

            $aux = array_values($aux);

            return (count($aux) > 0) ? $aux[0] : null;
        }


        private function SaveData() {
            $arrayEncode = array();

            foreach($this->ownersList as $owner) {
                $value["idUser"] = $owner->getUser()->getId();
                $value["idOwner"] = $owner->getIdOwner();
                $value["adress"] = $owner->getAdress();
                
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
                    $user=new User();
                    $user->setId($value["idUser"]);

                    $owner = new Owner();
                    $owner->setUser($user);
                    $owner->setIdOwner($value["idOwner"]);
                    $owner->setAdress($value["adress"]);

                    array_push($this->ownersList, $owner);
                }
            }
        }

        private function GetNextId() {
            $id = 0;

            foreach($this->ownersList as $owner) {
                $id = ($owner->getIdOwner() > $id) ? $owner->getIdOwner() : $id;
            }

            return $id + 1;
        }
    }
?>