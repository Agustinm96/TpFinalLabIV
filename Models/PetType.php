<?php 
namespace Models;

class PetType{

    private $petTypeId; // 0 dog; 1 cat; 2 guinea pig;
    private $petTypeName;
    // private $petImg;
    


    /**
     * Get the value of petTypeId
     */ 
    public function getPetTypeId()
    {
        return $this->petTypeId;
    }

    /**
     * Set the value of petTypeId
     *
     * @return  self
     */ 
    public function setPetTypeId($petTypeId)
    {
        $this->petTypeId = $petTypeId;

        return $this;
    }

    /**
     * Get the value of petTypeName
     */ 
    public function getPetTypeName()
    {
        return $this->petTypeName;
    }

    /**
     * Set the value of petTypeName
     *
     * @return  self
     */ 
    public function setPetTypeName($petTypeName)
    {
        $this->petTypeName = $petTypeName;

        return $this;
    }
}


?>