<?php 
    namespace Models;

    use Models\User;

    class Owner{
        private User $user;
        private $idOwner;
        private $adress;


        public function getUser()
        {
                return $this->user;
        }

        public function setUser(User $user): self
        {
                $this->user = $user;

                return $this;
        }

        public function getIdOwner()
        {
                return $this->idOwner;
        }

        public function setIdOwner($idOwner): self
        {
                $this->idOwner = $idOwner;

                return $this;
        }

        public function getAdress()
        {
                return $this->adress;
        }

        public function setAdress($adress): self
        {
                $this->adress = $adress;

                return $this;
        }
    }
?>