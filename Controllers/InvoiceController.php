<?php
    namespace Controllers;
    use Models\Reserve;
    use Models\Invoice;
    //use Controllers\ReviewController;
    use DAO\InvoiceDAO;
    use DAO\ReviewDAO;

    class InvoiceController
    {

        public $invoiceDAO;
        private $reviewDAO;

        public function __construct() {
            $this->invoiceDAO = new InvoiceDAO();
            $this->reviewDAO = new ReviewDAO();
            //$this->reviewController = new ReviewController();
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
            $this->reviewDAO->AddReview($reserve->getPet()->getId_User()->getId());
            $this->invoiceDAO->Add($invoice);
        }

        


    }
?>