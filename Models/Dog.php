<?php 
namespace Models;

class Dog extends Pet {
private $size;
private $vaccinationPlan; /// Picture Format
private $race;


   /* public function __construct(Pet $pet)
    {
     $this->setName($pet->getName());
     $this->setPetType($pet->getPetType());
     $this->setBirthDate($pet->getBirthDate());
     $this->setPicture($pet->getPicture());
     $this->setObservation($pet->getObservation());

    } */ // Posible funcion que combine pet preguntar




/**
 * Get the value of size
 */ 
public function getSize()
{
return $this->size;
}

/**
 * Set the value of size
 *
 * @return  self
 */ 
public function setSize($size)
{
$this->size = $size;

return $this;
}

/**
 * Get the value of vaccinationPlan
 */ 
public function getVaccinationPlan()
{
return $this->vaccinationPlan;
}

/**
 * Set the value of vaccinationPlan
 *
 * @return  self
 */ 
public function setVaccinationPlan($vaccinationPlan)
{
$this->vaccinationPlan = $vaccinationPlan;

return $this;
}

/**
 * Get the value of race
 */ 
public function getRace()
{
return $this->race;
}

/**
 * Set the value of race
 *
 * @return  self
 */ 
public function setRace($race)
{
$this->race = $race;

return $this;
}
}

?>