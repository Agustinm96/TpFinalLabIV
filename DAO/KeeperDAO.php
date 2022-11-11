<?php

    namespace DAO;

    use Models\Keeper;
    use Models\User;
    use Models\Dog;
    use Models\Cat;
    use Models\Availability;
    use DAO\UserDAO;

    class KeeperDAO implements IKeeperDAO {
        private $tableName = "Keeper";
        private $availabilityDAO;
        private $connection;
        private $userDAO;
        

        public function __construct(){
            $this->userDAO = new UserDAO();
            $this->availabilityDAO = new AvailabilityDAO();
            $this->connection = new Connection();
        }

        public function Add(Keeper $keeper) {
            $sql = "INSERT INTO Keeper (id_Keeper, id_user, adress, petSizeToKeep, priceToKeep, startingDate, lastDate, petsAmount) VALUES (:id_Keeper, :id_user, :adress, :petSizeToKeep, :priceToKeep, :startingDate, :lastDate, :petsAmount)";

        //autoincremental Id in db
        $parameters['id_Keeper'] = 0;
        $parameters['id_user'] =  $keeper->getUser()->getId();
        $parameters['adress'] = $keeper->getAdress();
        $parameters['petSizeToKeep'] = $keeper->getPetSizeToKeep();
        $parameters['priceToKeep'] = $keeper->getPriceToKeep();
        $parameters['startingDate'] = $keeper->getStartingDate();
        $parameters['lastDate'] =  $keeper->getLastDate();
        $parameters['petsAmount'] =  $keeper->getPetsAmount();

        try {
            $this->connection = Connection::getInstance();
            return $this->connection->ExecuteNonQuery($sql, $parameters, true);
        } catch (\PDOException $ex) {
            throw $ex;
        }
    }

        public function Remove($idUser) {
            $sql="DELETE FROM Keeper WHERE Keeper.id_user=:id_user";
            $values['id_user'] = $idUser;
    
            try{
                $this->connection= Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql,$values);
            }catch(\PDOException $ex){
                throw $ex;
            }
        }

        public  function GetAll() {
            $sql = "SELECT * FROM Keeper";
    
            try{
                $this->connection = Connection::getInstance();
                $result = $this->connection->Execute($sql);
            }catch(\PDOException $ex){
                throw $ex;
            }
            if(!empty($result)){
                return $this->mapear($result);
            }else{
                return false;
            }
        }

        protected function mapear ($value){

            $value = is_array($value) ? $value : [];
            
            $resp = array_map(function($p){
                $user = new User();
                $user = $this->userDAO->GetById($p['id_user']);
                $keeper = new Keeper();
                $keeper->setIdKeeper($p['id_Keeper']);
                $keeper->setUser($user);

                $keeper->setAdress($p['adress']);
                $keeper->setPetSizeToKeep($p['petSizeToKeep']);
                $keeper->setPriceToKeep($p["priceToKeep"]);
                $keeper->setStartingDate($p["startingDate"]);
                $keeper->setLastDate($p["lastDate"]);
                $keeper->setPetsAmount($p["petsAmount"]);
                
                return $keeper;
            }, $value);
    
            return count($resp) > 1 ? $resp : $resp['0'];
        }

        public function GetById($idKeeper) {
            $sqlSelectId = "select * from Keeper where id_Keeper = '".$idKeeper."';";
        try{
            $this->connection = Connection::getInstance();
            $result = $this->connection->Execute($sqlSelectId);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($result)){
            return $this->mapear($result);
        }else{
            return false;
            }
        }

        public function GetByIdUser($idUser) {
            $sqlSelectId = "select * from Keeper where id_user = '".$idUser."';";
            try{
                $this->connection = Connection::getInstance();
                $result = $this->connection->Execute($sqlSelectId);
            }catch(\PDOException $ex){
                throw $ex;
            }
            if(!empty($result)){
                return $this->mapear($result);
            }else{
                return false;
            }
        }

        public function getAvailableKeepersByDates($availabilityList, $initDate, $lastDate){
            $avaiableKeepersList=array();
            
            while($initDate <= $lastDate){
                foreach($availabilityList as $availability){
                        if($availability->getDate() === $initDate && $availability->getAvailable()==1){
                            $keeper = $this->GetById($availability->getIdKeeper());
                            array_push($avaiableKeepersList, $keeper); 
                            }
                        }
                    $initDate = date('Y-m-d', strtotime($initDate)+86400); 
                    }
                    
            $arrFinal = array_unique($avaiableKeepersList,SORT_REGULAR);
            return $arrFinal;
        }

        public function Modify(Keeper $keeper) {
            /**/
        }
    }
?>