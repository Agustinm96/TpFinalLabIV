<?php 
namespace Models;

use Models\User;
class Owner extends User{

    private $idOwner;


    public function getIdOwner()
    {
        return $this->idOwner;
    }

    public function setIdOwner($idOwner): self
    {
        $this->idOwner = $idOwner;

        return $this;
    }
}

?>