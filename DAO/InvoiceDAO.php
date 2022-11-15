<?php

namespace DAO;

use Models\Reserve;
use Models\Invoice;

class InvoiceDAO{
    private $reserveDAO;

    public function __construct(){
        $this->reserveDAO = new ReserveDAO();
    }

    public function Add($invoice) {
        $sql = "INSERT INTO Invoice (id_invoice, id_reserve, isPayed) VALUES (:id_invoice, :id_reserve, :isPayed)";

        //autoincremental Id in db
        $parameters['id_invoice'] = 0;
        $parameters['id_reserve'] =  $invoice->getReserve()->getId();
        $parameters['isPayed'] = $invoice->getIsPayed();

        try {
            $this->connection = Connection::getInstance();
            return $this->connection->ExecuteNonQuery($sql, $parameters, true);
        } catch (\PDOException $ex) {
            throw $ex;
        }
        
    }

    public function Remove($id) {
        $sql="DELETE FROM Invoice i WHERE i.id_invoice=:id";
            $values['id_invoice'] = $id;
    
            try{
                $this->connection= Connection::getInstance();
                return $this->connection->ExecuteNonQuery($sql,$values);
            }catch(\PDOException $ex){
                throw $ex;
            }
    }


    public  function GetAll() {
        $sql = "SELECT * FROM Invoice i
        join Reserva r on i.id_reserva=r.id_reserva 
        join pet p on r.id_pet=p.id_Pet 
        join User u on p.id_user=u.id_user
        join Availability a on r.id_availability=a.id_availability
        ORDER BY a.`dateSpecific`,u.id_user;";
    
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

    public function GetById($id) {
        $sqlSelectId = "select * from Invoice where id_invoice = '".$id."';";
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

    protected function mapear ($value){

        $value = is_array($value) ? $value : [];
        
        $resp = array_map(function($p){
            $reserve = $this->reserveDAO->GetById($p["id_reserve"]);

            $invoice = new Invoice();
            $invoice->setIdInvoice($p['id_invoice']);
            $invoice->setReserve($reserve);
            $invoice->setIsPayed($p['isPayed']);
            
            return $invoice;
        }, $value);

        return count($resp) > 1 ? $resp : $resp['0'];
    }

    }


?>