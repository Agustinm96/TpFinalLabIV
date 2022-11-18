<?php
    namespace Controllers;
    use Models\Reserve;
    use Models\Invoice;
    use DAO\InvoiceDAO;

    class InvoiceController
    {

        public $invoiceDAO;

        public function __construct() {
            $this->invoiceDAO = new InvoiceDAO();
        }

        public function showGenerateAndSendView(Reserve $reserve){
            require_once(VIEWS_PATH . "validate-session.php");
            require_once(VIEWS_PATH."generateAndSendInvoice.php");
        }


        public function Add(Reserve $reserve)
        {
            $invoice=new Invoice();
            $invoice->setReserve($reserve);
            $invoice->setIsPayed(0);

            $this->invoiceDAO->Add($invoice);
        }

        


    }
?>