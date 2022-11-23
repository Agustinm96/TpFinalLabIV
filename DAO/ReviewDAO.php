<?php
namespace DAO;


use \Exception as Exception;
use Models\User as User;
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

    public function Add(Review $newReview)
    {$reviewAux->setSwitchOwnerKeeper(0); //Para q se vea en el owner
        $reviewAux->setDateShowReview($date);
        try
        {
            $query = "INSERT INTO ".$this->tableName." (id_Owner,id_Keeper,
            switchOwnerKeeper,dateShowReview)
             VALUES (:id_Owner, :id_Keeper, :switchOwnerKeeper, :dateShowReview)";
            $parameters["id_Owner"] = $newReview->getId_Owner()->getId();
            $parameters["id_Keeper"] = $newReview->getId_Keeper()->getId();
            $parameters["switchOwnerKeeper"] = $newReview->getSwitchOwnerKeeper();
            $parameters["dateShowReview"] = $newReview->getDateShowReview();
            $this->connection = Connection::GetInstance();

            $this->connection->ExecuteNonQuery($query, $parameters);
            
        }
        catch(Exception $ex)
        {
            throw $ex;
        }
    }
 


    public function getByIdKeeper($id_Keeper)
    {
        $query = "SELECT * FROM ".$this->tablename." WHERE $id_Keeper = 
        ".$this->tablename.".id_Keeper WHERE ".$this->tablename.".switOwnerKeeper=1" ;
        
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
            $review->setDateShowReview($content['dateShowReview']);
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
            $query = "UPDATE $var SET score='$score', reviewMsg='$reviewMsg' switchOwnerKeeper=1,
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
        date_default_timezone_set('Argentina');
        $date = date('m/d/Y h:i:s a', time());
        $query = "SELECT * FROM ".$this->tablename." WHERE $id_Owner = 
        ".$this->tablename.".id_Owner AND $date>".$this->tablename.".dateShowReview";
            
        try{
            $this->connection = Connection::getInstance();
            $contentArray = $this->connection->Execute($query);
        }catch(\PDOException $ex){
            throw $ex;
        }
        if(!empty($contentArray)){
            return $this->mapear($contentArray);
        }else{
            return false;
        }
    }

}
?>
