<?php 
    namespace Models;

    use Models\Reserve;

    class Invoice{
        private $id_invoice;
        private Reserve $reserve;
        private $isPayed;
        

        public function getIdInvoice()
        {
                return $this->id_invoice;
        }

        public function setIdInvoice($id_invoice): self
        {
                $this->id_invoice = $id_invoice;

                return $this;
        }

        public function getReserve(): Reserve
        {
                return $this->reserve;
        }

        public function setReserve(Reserve $reserve): self
        {
                $this->reserve = $reserve;

                return $this;
        }

        public function getIsPayed()
        {
                return $this->is_payed;
        }

        public function setIsPayed($is_payed): self
        {
                $this->is_payed = $is_payed;

                return $this;
        }
    }
?>