<?php

    namespace DAO;

    use Models\Reserve;

    class ReserveDAO implements IReserveDAO {
        private $fileName = ROOT . "/Data/reserves.json";
        private $reservesList = array();

        public function Add($reserve) {
            $this->RetrieveData();

            $reserve->setIdOwner($this->GetNextId());

            array_push($this->reservesList, $reserve);

            $this->SaveData();
        }

        public function Remove($idReserve) {
            $this->RetrieveData();

            $this->reservesList = array_filter($this->reservesList, function($reserve) use($idReserve) {
                return $reserve->getIdReserve() != $idReserve;
            });

            $this->SaveData();
        }

        public  function GetAll() {
            $this->RetrieveData();
            return $this->reservesList;
        }

        public function GetById($id) {
            $this->RetrieveData();

            $aux = array_filter($this->reservesList, function($reserve) use($id) {
                return $reserve->getIdReserve() == $id;
            });

            $aux = array_values($aux);

            return (count($aux) > 0) ? $aux[0] : null;
        }

        private function SaveData() {
            $arrayEncode = array();

            foreach($this->reservesList as $reserve) {
                
                $value["idReserve"] = $reserve->getIdReserve();
                $value["idKeeper"] = $reserve->getIdKeeper();
                $value["startingDate"] = $reserve->getStartingDate();
                $value["lastDate"] = $reserve->getlastDate();
                $value["daysToWork"] = $reserve->getArrayDays();
                $value["isAvailable"] = $reserve->getIsAvailable();
            
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
                    $reserve = new Reserve();
                    $reserve->setIdReserve($value["idReserve"]);
                    $reserve->setIdKeeper($value["idKeeper"]);
                    $reserve->setStartingDate($value["startingDate"]);
                    $reserve->setLastDate($value["lastDate"]);
                    $reserve->setArrayDays($value["arrayDays"]);
                    $reserve->setIsAvailable($value["isAvailable"]);

                    array_push($this->reservesList, $reserve);
                }
            }
        }

        private function GetNextId() {
            $id = 0;

            foreach($this->reservesList as $reserve) {
                $id = ($reserve->getIdReserve() > $id) ? $reserve->getIdReserve() : $id;
            }

            return $id + 1;
        }
    }
?>