<?php 
    namespace Models;

    use Models\User;

    class Owner{
        private $user;
        private $idAdmin;

        public function getUser()
        {
                return $this->user;
        }

        public function setUser(User $user): self
        {
                $this->user = $user;

                return $this;
        }

        public function getIdAdmin()
        {
                return $this->idAdmin;
        }

        public function setIdAdmin($idAdmin): self
        {
                $this->idAdmin = $idAdmin;

                return $this;
        }
    }
?>