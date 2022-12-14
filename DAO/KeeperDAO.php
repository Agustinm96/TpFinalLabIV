<?php

    namespace DAO;

    use Models\Keeper;
    use Models\User;
    use Models\Reserve;

    class KeeperDAO implements IKeeperDAO {
        private $fileName = ROOT . "/Data/keepers.json";
        private $keepersList = array();

        public function Add($keeper) {
            $this->RetrieveData();

            $keeper->setIdKeeper($this->GetNextId());

            array_push($this->keepersList, $keeper);

            $this->SaveData();
        }

        public function Remove($idKeeper) {
            $this->RetrieveData();

            $this->keepersList = array_filter($this->keepersList, function($keeper) use($idKeeper) {
                return $keeper->getIdKeeper() != $idKeeper;
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
                return $keeper->getIdKeeper() == $idKeeper;
            });

            $aux = array_values($aux);

            return (count($aux) > 0) ? $aux[0] : null;
        }

        public function GetByIdUser($idUser) {
            $this->RetrieveData();

            $aux = array_filter($this->keepersList, function($keeper) use($idUser) {
                return $keeper->getUser()->getId() == $idUser;
            });

            $aux = array_values($aux);

            return (count($aux) > 0) ? $aux[0] : null;
        }

        private function SaveData() {
            $arrayEncode = array();

            foreach($this->keepersList as $keeper) {
                $value["idUser"] = $keeper->getUser()->getId();
                $value["idKeeper"] = $keeper->getIdKeeper();
                $value["adress"] = $keeper->getAdress();
                $value["petSizeToKeep"] = $keeper->getPetSizeToKeep();
                $value["priceToKeep"] = $keeper->getPriceToKeep();
                $value["initDate"] = $keeper->getReserve()->getStartingDate();
                $value["lastDate"] = $keeper->getReserve()->getLastDate();
                $value["daysToWork"] = $keeper->getReserve()->getArrayDays();
                $value["isAvailable"] = $keeper->getReserve()->getIsAvailable();

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
                    $user=new User();
                    $user->setId($value["idUser"]);

                    $keeper = new Keeper();
                    $keeper->setUser($user);
                    $keeper->setIdKeeper($value["idKeeper"]);
                    $keeper->setAdress($value["adress"]);
                    $keeper->setPetSizeToKeep($value["petSizeToKeep"]);
                    $keeper->setPriceToKeep($value["priceToKeep"]);
                    $reserve = new Reserve();
                    $reserve->setStartingDate($value["initDate"]);
                    $reserve->setLastDate($value["lastDate"]);
                    $reserve->setArrayDays($value["daysToWork"]);
                    $reserve->setIsAvailable($value["isAvailable"]);
                    $keeper->setReserve($reserve);

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

        public function Modify(Keeper $keeper) {
            $this->RetrieveData();
            /*tendria que llamar a modify user */ 
            $this->Remove($keeper->getIdKeeper());

            array_push($this->keepersList, $keeper);

            $this->SaveData();
        }
    }
?>