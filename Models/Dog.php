<?php 
namespace Models;

class Dog extends Pet {
private $size;
private $vaccinationPlan; /// Picture Format
private $race;
private $id_Dog;
private $id_Pet;

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

/**
 * Get the value of id_Dog
 */ 
public function getId_Dog()
{
return $this->id_Dog;
}

/**
 * Set the value of id_Dog
 *
 * @return  self
 */ 
public function setId_Dog($id_Dog)
{
$this->id_Dog = $id_Dog;

return $this;
}

/**
 * Get the value of id_Pet
 */ 
public function getId_Pet()
{
return $this->id_Pet;
}

/**
 * Set the value of id_Pet
 *
 * @return  self
 */ 
public function setId_Pet($id_Pet)
{
$this->id_Pet = $id_Pet;

return $this;
}
}

?>