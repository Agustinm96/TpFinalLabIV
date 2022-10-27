<?php

    namespace DAO;

    use Models\Keeper;
    use Models\User;
    use Models\Dog;
    use Models\Cat;
    use Models\Reserve;
    use Models\Availability;

    class KeeperDAO implements IKeeperDAO {
        private $fileName = ROOT . "/Data/keepers.json";
        private $keepersList = array();

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

        public function getAvailableKeepersByDates($initDate, $lastDate){
            $keepersList = $this->GetAll();
            $avaiableKeepersList=array();

            while($initDate <= $lastDate){
                foreach($keepersList as $keeper){
                    $arrayDates = $keeper->getAvailabilityArray();
                    foreach($arrayDates as $date){
                        if($date->getDate() === $initDate){
                                array_push($avaiableKeepersList, $keeper); 
                            }
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
                $value["initDate"] = $keeper->getReserve()->getStartingDate();
                $value["lastDate"] = $keeper->getReserve()->getLastDate();
                $value["daysToWork"] = $keeper->getReserve()->getArrayDays();

                $array = array();
                $availabilityArray = $keeper->getavailabilityArray();
                foreach($availabilityArray as $availability){
                    
                    $arrayPetName = array();
                    $arrayNames = array();
                    $values["date"] = $availability->getDate();
                    $values["available"] = $availability->getAvailable();
                    $values["reserveRequest"] = $availability->getReserveRequest();

                    $arrayUserName = $availability->getUserName();
            
                    if($arrayUserName){
                        foreach((array)$arrayUserName as $name){
                        $stringName = $name;
                        array_push($arrayNames, $stringName);
                        }
                    }
                    
                    $values["userName"] = $arrayNames;

                    $petArray = $availability->getPetList();
                    
                    if($petArray){
                        foreach($petArray as $pet){  
                        if(is_string($pet)){
                            array_push($arrayPetName, $pet);
                        }elseif(($pet instanceof Dog) || ($pet instanceof Cat)){
                            $petName = $pet->getName(). " ";
                            $petName .= $pet->getPetType(); //concateno el nombre y el tipo
                            array_push($arrayPetName, $petName);
                            }
                        }
                    }
                    $values["petName"] = $arrayPetName;

                    array_push($array, $values);
                    }
                $value["availabilityArray"] = $array;

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
                    $keeper->setReserve($reserve);

                    $array=array();
                    $availabilityArray=$value["availabilityArray"];
                    foreach($availabilityArray as $valueD){
                        $availability = new Availability();
                        $availability->setDate($valueD['date']);
                        $availability->setAvailable($valueD['available']);
                        $availability->setReserveRequest($valueD['reserveRequest']);
                        $availability->setUserName($valueD['userName']);
                        $availability->setPetList($valueD['petName']);
                        array_push($array, $availability);
                    }
                    
                    $keeper->setavailabilityArray($array);

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