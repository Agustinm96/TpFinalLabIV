<?php
namespace Controllers;



use Models\Pet as Pet;
use DAO\DogDAO as DogDAO;
use DAO\PetDAO as PetDAO;

class PetController {
private $petDAO;

    public function __construct()
    {
        $this->petDAO = new petDAO();
    }
    
  /*  public function ShowPerfilView($IDUser){
        //require_once(VIEWS_PATH . "validate-session.php");
        $petList = $this->petDAO->GetAllbyUserID();
        require_once(VIEWS_PATH . "perfil-index.php");
    } */

    public function ShowAddView() {
        //require_once(VIEWS_PATH . "validate-session.php");
        require_once(VIEWS_PATH . "add-dog.php");
    }

    public function ShowListView() {
        //require_once(VIEWS_PATH . "validate-session.php");
        $petList = $this->petDAO->GetAll();
        require_once(VIEWS_PATH . "perfil-petlist.php");
    }

        public function Remove($id)
        {
            $this->petDAO->Remove($ID);

            $this->ShowPerfilView();
        }


}



?>