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

    
    public function CallHomeReview($message =""){
        require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "home.php");
        }

        public function ShowReview($id_Review){
            require_once(VIEWS_PATH . "validate-session.php");
            $review = $this->reviewDAO->getById_Review($id_Review);
            require_once(VIEWS_PATH . "complete-review.php");

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

    public function CompleteReview($id_Review,$score, $review ){
        require_once(VIEWS_PATH . "validate-session.php");
        $this->reviewDAO->Modify($score,$review,$id_Review);
        $this->CallHomeReview("Se ah Completado el formulario con exito");
    }

    public function ViewInfo($id_Keeper){
        require_once(VIEWS_PATH . "validate-session.php");
        $keeper = $this->userController->userDAO->GetById($id_Keeper);
        $reviewList = $this->reviewDAO->getByIdKeeper($id_Keeper);
        $score =0;
        $scoreCount=0;
        if(!is_null($reviewList)){
            foreach($reviewList as $review){
                $score = $score + $review->getScore();
                $scoreCount++;
            }
        }
        require_once(VIEWS_PATH . "view-infokeeper.php");
      }

    public function checkReviewAvariableFromOwner(){
        //Agarrar reviews generadas y segun fecha mostrar o no;
        //pasar id de owner y date de hoy;
        $listReview = $this->reviewDAO->getByIdAndDate($_SESSION["loggedUser"]->getId());

    }
           //Solo podra ser llamada por el keeper.
           public function AddReview($id_Owner,$date){
            $auxUserKeeper = new User();
            $auxUserOwner = new User();
            $reviewAux = new Review();
            $auxUserKeeper->setId($_SESSION["loggedUser"]->getId());
            $auxUserOwner->setId($id_Owner);
            $reviewAux->setId_Keeper($auxUserKeeper);
            $reviewAux->setId_Owner($auxUserOwner);
            $reviewAux->setSwitchOwnerKeeper(0); //Para q se vea en el owner
            $reviewAux->setDateShowReview($date);
            $this->Add($reviewAux);
            //$this->mostrarvista(); redireccionar a vista o no, que se encargue el keeper;
            }

}


    ?>