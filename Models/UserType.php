<?php 
namespace Models;

use Models\User;

class UserType{
    private $id_userType;
    private $typeName;
    private $description;
    

    public function getId()
    {
        return $this->id_userType;
    }

    public function setId($id_userType): self
    {
        $this->id_userType = $id_userType;

        return $this;
    }

    public function getName()
    {
        return $this->typeName;
    }

    public function setName($typeName): self
    {
        $this->typeName = $typeName;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }
}

?>