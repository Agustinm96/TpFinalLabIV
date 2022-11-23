<?php
namespace Controllers;

use DAO\ReviewDAO as ReviewDAO;
use MODELS\User as User;
use MODELS\Review as Review;

Class ReviewController{
    private $userController;
    private $reviewDAO;

    public function __construct()

    {
        $this->reviewDAO = new ReviewDAO();
        $this->userController = new UserController();

    }


    //Solo podra ser llamada por el keeper.
    public function Add($id_Owner,$date){
    $auxUserKeeper = new User();
    $auxUserOwner = new User();
    $reviewAux = new Review();
    $auxUserKeeper->setId($_SESSION["loggedUser"]->getId());
    $auxUserOwner->setId($id_Owner);
    $reviewAux->setId_Keeper($auxUserKeeper);
    $reviewAux->setId_Owner($auxUserOwner);
    $reviewAux->setSwitchOwnerKeeper(0); //Para q se vea en el owner
    $reviewAux->setDateShowReview($date);
    $this->reviewDAO->Add($reviewAux);
    //$this->mostrarvista(); redireccionar a vista o no, que se encargue el keeper;
    }


    public function GetAllScore($id_Keeper){
    $listReview = $this->reviewDAO->getByIdKeeper($id_Keeper);
    $sum=0;
    $i=0;
    if($listReview){
     foreach($listReview as $review){
             $sum= $sum+$review->getScore();
            $i++;
        }
        return $sum/$i;
    }else{
        return $sum;
    }
    }

    public function CompleteReview($score, $review , $id_Review){
        $this->reviewDAO->Modify($score,$review,$id_Review);
        //llamado de vista.
    }


    public function checkReviewAvariableFromOwner(){
        //Agarrar reviews generadas y segun fecha mostrar o no;
        //pasar id de owner y date de hoy;
        $listReview = $this->reviewDAO->getByIdAndDate($_SESSION["loggedUser"]->getId());

    }

}


    ?>