<?php
    namespace Controllers;
    use Models\Reserve;
    use Models\Invoice;
    use DAO\InvoiceDAO;

    class InvoiceController
    {

        private $invoiceDAO;

        public function __construct() {
            $this->invoiceDAO = new InvoiceDAO();
        }

        public function showGenerateAndSendView(Reserve $reserve){
            require_once(VIEWS_PATH . "validate-session.php");
            var_dump($reserve);
            require_once(VIEWS_PATH."generateAndSendInvoice.php");
        }


        public function Add(Reserve $reserve)
        {
            $invoice=new Invoice();
            $invoice->setReserve($reserve);
            $invoice->setIsPayed(false);

            $this->invoiceDAO->Add($invoice);
            $this->showGenerateAndSendView();
        }


    }
?>