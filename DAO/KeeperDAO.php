<?php

    namespace DAO;

    use Models\Keeper;

    class KeeperDAO implements IKeeperDAO {
        private $fileName = ROOT . "/Data/keepers.json";
        private $keepersList = array();

        public function Add($keeper) {
            $this->RetrieveData();

            $keeper->setId($this->GetNextId());

            array_push($this->keepersList, $keeper);

            $this->SaveData();
        }

        public function Remove($idKeeper) {
            $this->RetrieveData();

            $this->keepersList = array_filter($this->keepersList, function($keeper) use($idKeeper) {
                return $keeper->getId() != $idKeeper;
            });

            $this->SaveData();
        }

        public  function GetAll() {
            $this->RetrieveData();
            return $this->keepersList;
        }

        public function GetById($idKeeper) {
            $this->RetrieveData();

            $aux = array_filter($this->keepersList, function($keeper) use($idKeeper) {
                return $keeper->getIdKeeper() == $id;
            });

            $aux = array_values($aux);

            return (count($aux) > 0) ? $aux[0] : null;
        }

        private function SaveData() {
            $arrayEncode = array();

            foreach($this->keepersList as $keeper) {
                
                $value["firstName"] = $keeper->getFirstName();
                $value["lastName"] = $keeper->getLastName();
                $value["dni"] = $keeper->getDni();
                $value["email"] = $keeper->getEmail();
                $value["phoneNumber"] = $keeper->getPhoneNumber();
                $value["idKeeper"] = $keeper->getIdKeeper();
                $value["petSizeToKeep"] = $keeper->getPetSizeToKeep();
                $value["isAvailable"] = $keeper->getIsAvailable();

                array_push($arrayEncode, $value);
            }

            $jsonContent = json_encode($arrayEncode, JSON_PRETTY_PRINT);
            file_put_contents($this->fileName, $jsonContent);
        }

        private function RetrieveData() {
            $this->keepersList = array();

            if(file_exists($this->fileName)) {
                $jsonContent = file_get_contents($this->fileName);
                $arrayDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayDecode as $value) {
                    $keeper = new Keeper();
                    $keeper->setFirstName($value["firstName"]);
                    $keeper->setLastName($value["lastName"]);
                    $keeper->setDni($value["dni"]);
                    $keeper->setEmail($value["email"]);
                    $keeper->setPhoneNumber($value["phoneNumber"]);
                    $keeper->setIdKeeper($value["idKeeper"]);
                    $keeper->setPetSizeToKeep($value["petSizeToKeep"]);
                    $keeper->setIsAvailable($value["isAvailable"]);

                    array_push($this->keepersList, $keeper);
                }
            }
        }

        private function GetNextId() {
            $id = 0;

            foreach($this->keepersList as $keeper) {
                $id = ($keeper->getIdKeeper() > $id) ? $keeper->getIdKeeper() : $id;
            }

            return $id + 1;
        }
    }
?>