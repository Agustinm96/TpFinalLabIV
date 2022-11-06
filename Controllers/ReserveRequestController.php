<?php

namespace Controllers;

use DAO\ReserveRequestDAO;

class ReserveRequestController{
    public $reserveRequestDAO;

    public function __construct() {
        $this->reserveRequestDAO = new ReserveRequestDAO;
    }

    public function Add (ReserveRequest $reserveRequest){
        require_once(VIEWS_PATH . "validate-session.php");
        
        $this->reserveRequestDAO->Add($reserveRequest);
    }

    
}

?>