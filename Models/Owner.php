<?php 
namespace Models;

use Models\Person;
class Owner extends Person{

    private $idOwner;
    private $username;
    private $password;
    


    public function getIdOwner()
    {
        return $this->idOwner;
    }

    public function setIdOwner($idOwner): self
    {
        $this->idOwner = $idOwner;

        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password): self
    {
        $this->password = $password;

        return $this;
    }
}

?>