<?php

    namespace DAO;

    use Models\Keeper;
    use Models\User;
    use Models\Dog;
    use Models\Cat;
    use Models\Availability;

    class KeeperDAO implements IKeeperDAO {
        private $fileName = ROOT . "/Data/keepers.json";
        private $keepersList = array();
        private $availabilityDAO;
        

        public function __construct(){
            $this->availabilityDAO = new AvailabilityDAO();
            
        }

        public function Add($keeper) {
            $this->RetrieveData();

            $keeper->setIdKeeper($this->GetNextId());

            array_push($this->keepersList, $keeper);

            $this->SaveData();
        }

        public function Remove($idUser) {
            $this->RetrieveData();

            $this->keepersList = array_filter($this->keepersList, function($keeper) use($idUser) {
                return $keeper->getUser()->getId() != $idUser;
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

        function GetByUserName($userName){
            $this->RetrieveData();
    
            $aux = array_filter($this->keepersList, function($keeper) use($userName){
                return $keeper->getUser()->getUserName() == $userName;
            });
    
            $aux = array_values($aux); //Reorderding array
    
            return (count($aux) > 0) ? $aux[0] : null;
    
        }

        public function getAvailableKeepersByDates($availabilityList, $initDate, $lastDate){
            $avaiableKeepersList=array();

            while($initDate <= $lastDate){
                foreach($availabilityList as $availability){
                        if($availability->getDate() === $initDate){
                            $keeper = $this->GetById($availability->getIdKeeper());
                            array_push($avaiableKeepersList, $keeper); 
                            }
                        }
                    $initDate = date('Y-m-d', strtotime($initDate)+86400); 
                    }
                    
            $arrFinal = array_unique($avaiableKeepersList,SORT_REGULAR);
    
            return $arrFinal;
        }

        private function SaveData() {
            $arrayEncode = array();

            foreach($this->keepersList as $keeper){
                $value["idUser"] = $keeper->getUser()->getId();
                $value["idKeeper"] = $keeper->getIdKeeper();
                $value["adress"] = $keeper->getAdress();
                $value["petSizeToKeep"] = $keeper->getPetSizeToKeep();
                $value["priceToKeep"] = $keeper->getPriceToKeep();
                $value["initDate"] = $keeper->getStartingDate();
                $value["lastDate"] = $keeper->getLastDate();
                $value["daysToWork"] = $keeper->getArrayDays();
                $value["petsAmount"] = $keeper->getPetsAmount();
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
                    $keeper->setStartingDate($value["initDate"]);
                    $keeper->setLastDate($value["lastDate"]);
                    $keeper->setArrayDays($value["daysToWork"]);
                    $keeper->setPetsAmount($value["petsAmount"]);

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
            
            $this->Remove($keeper->getUser()->getId());

            array_push($this->keepersList, $keeper);

            $this->SaveData();
        }
    }
?>