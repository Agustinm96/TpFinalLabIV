<?php
namespace DAO;


use \Exception as Exception;
use Models\User as User;
use Models\Review as Review;
use DAO\Connection as Connection;
use DAO\UserDAO as UserDAO;

class ReviewDAO{
    private $connection;
    private $tableName = "review";
    private $reviewList = array();
    private $userDAO;

    public function __construct()
    {
        $this->connection = new Connection();
        $this->userDAO = new UserDAO();
    }

       //Solo podra ser llamada por el keeper.
       public function AddReview($id_Owner){
        $auxUserKeeper = new User();
        $auxUserOwner = new User();
        $reviewAux = new Review();
        $auxUserKeeper->setId($_SESSION["loggedUser"]->getId());
        $auxUserOwner->setId($id_Owner);
        $reviewAux->setId_Keeper($auxUserKeeper);
        $reviewAux->setId_Owner($auxUserOwner);
        $reviewAux->setSwitchOwnerKeeper(0); //Para q se vea en el owner
        $this->Add($reviewAux);
        //$this->mostrarvista(); redireccionar a vista o no, que se encargue el keeper;
        }
    
    public function Add(Review $newReview) {   
        try
        {
            $query = "INSERT INTO ".$this->tableName." (id_Owner,id_Keeper,
            switchOwnerKeeper)
             VALUES (:id_Owner, :id_Keeper, :switchOwnerKeeper)";
            $parameters["id_Owner"] = $newReview->getId_Owner()->getId();
            $parameters["id_Keeper"] = $newReview->getId_Keeper()->getId();
            $parameters["switchOwnerKeeper"] = $newReview->getSwitchOwnerKeeper();
            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
            
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }

    public function getById_Review($id)
    {
        $var = $this->tableName;
        $query = "SELECT * FROM $var WHERE $id=$var.id_Review" ;
        
        try{
            $this->connection = Connection::getInstance();
            $contentArray = $this->connection->Execute($query);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($contentArray)){
            foreach($contentArray as $content)
             {
            $review = new Review();
            $userOwner = $this->userDAO->GetById($content['id_Owner']);
            $userKeeper = $this->userDAO->GetById($content['id_Keeper']);
            $review->setId_Review($content['id_Review']);
            $review->setScore($content['score']);
            $review->setReviewMsg($content['reviewMsg']);
            $review->setSwitchOwnerKeeper($content['switchOwnerKeeper']);
            $review->setId_Owner($userOwner);
            $review->setId_Keeper($userKeeper);
         }
         return $review;
    }else{
        return null;
    }
    }

    public function getByIdKeeper($id_Keeper)
    {
        $var = $this->tableName;
        $query = "SELECT * FROM $var WHERE $id_Keeper = 
        $var.id_Keeper AND $var.switchOwnerKeeper=1" ;
        
        try{
            $this->connection = Connection::getInstance();
            $contentArray = $this->connection->Execute($query);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($contentArray)){
            foreach($contentArray as $content)
             {
            $review = new Review();
            $userOwner = $this->userDAO->GetById($content['id_Owner']);
            $userKeeper = $this->userDAO->GetById($content['id_Keeper']);
            $review->setId_Review($content['id_Review']);
            $review->setScore($content['score']);
            $review->setReviewMsg($content['reviewMsg']);
            $review->setSwitchOwnerKeeper($content['switchOwnerKeeper']);
            $review->setId_Owner($userOwner);
            $review->setId_Keeper($userKeeper);
            array_push($this->reviewList,$review);
         }
         return $this->reviewList;
    }else{
        return null;
    }
    }

    public function Modify($score , $reviewMsg, $id_Review ){

        $var = $this->tableName;
        try
        {
            $query = "UPDATE $var SET   score='$score', 
                                        reviewMsg='$reviewMsg',
                                        switchOwnerKeeper=1
            WHERE $var.id_Review=$id_Review";
            $this->connection = Connection::GetInstance();
            $this->connection->execute($query);
        }
        catch(Exception $ex)
        {
            throw $ex;
        }

    }

    public function checkReviewAvariableFromOwner($id_Owner){

        $var = $this->tableName;
        $query = "SELECT * FROM $var WHERE $id_Owner = 
        $var.id_Owner AND $var.switchOwnerKeeper=0";
            
        try{
            $this->connection = Connection::getInstance();
            $contentArray = $this->connection->Execute($query);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($contentArray)){
            $review =new Review();
                foreach($contentArray as $content)
                 {
            $userKeeperAux = new User();
            $userKeeperAux =$this->userDAO->getById($content['id_Keeper']);
            $userOwnerAux = new User();
            $userOwnerAux = $this->userDAO->getById($content['id_Owner']);
            $review->setId_Owner($userOwnerAux);
            $review->setId_Keeper($userKeeperAux);
            $review->setId_Review($content['id_Review']);
            $review->setSwitchOwnerKeeper($content['switchOwnerKeeper']);
                 }
            return $review;
        }else{
            return null;
        }
    }

}
?>
