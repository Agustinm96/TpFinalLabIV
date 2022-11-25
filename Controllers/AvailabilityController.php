<?php

namespace Controllers;

use Models\Keeper;
use Models\Availability;
use DAO\AvailabilityDAO;

class AvailabilityController{
    public $availabilityDAO;
    private $invoiceController;

    public function __construct(){
        $this->availabilityDAO = new AvailabilityDAO();
        $this->invoiceController = new InvoiceController(); //??? no se usa
    }

    public function Add ($keeper, $initDate, $finishDate, $daysToWork){
        require_once(VIEWS_PATH . "validate-session.php");
        
        $datesArray = $this->valiDate($keeper, $initDate, $finishDate, $daysToWork);

        foreach($datesArray as $date){
            $this->availabilityDAO->Add($date);
        }    
    }

    public function Modify($keeper, $initDate, $finishDate, $daysToWork){
        require_once(VIEWS_PATH . "validate-session.php");
        $datesArray = $this->valiDate($keeper, $initDate, $finishDate, $daysToWork);

        $availavilityList = $this->availabilityDAO->GetAll(); //primero elimino aquellas que coincidan con el id del keeper
        foreach($availavilityList as $availability){
            if($availability->getKeeper()->getIdKeeper() == $keeper->getIdKeeper()){
                //cargar invoice a eliminar
                $this->availabilityDAO->Remove($availability->getId());
            }
            
        } 
        foreach($datesArray as $date){ //luego agrego la nueva disponibilidad
            $this->availabilityDAO->Add($date);
        }
    }

    public function Remove($id)
    {
        $this->availabilityDAO->Remove($id);         

        $this->ShowListView();
    }


    public function dayName($startingDay){
        $fechats = strtotime($startingDay); 
        switch (date('w', $fechats)){
            case 0: return "Sunday"; break;
            case 1: return "Monday"; break;
            case 2: return "Tuesday"; break;
            case 3: return "Wednesday"; break;
            case 4: return "Thursday"; break;
            case 5: return "Friday"; break;
            case 6: return "Saturday"; break;
            }  
    }

    public function valiDate($keeper, $startingDay, $finishDate, $daysToWork){
        
        $datesArray = array();
        while($startingDay <= $finishDate){
            $string = $this->dayName($startingDay);
            foreach($daysToWork as $day){
                if($string===$day){
                    $availability = new Availability();
                    $availability->setKeeper($keeper);
                    $availability->setDate($startingDay);
                    $availability->setAvailable(1);
                    array_push($datesArray, $availability);
                }
            } 
            $startingDay = date('Y-m-d', strtotime($startingDay)+86400);  
        }
        return $datesArray;
    }

}

?>