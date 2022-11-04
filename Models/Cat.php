<?php 
namespace Models;

class Cat extends Pet {
private $vaccinationPlan; /// Picture Format
private $race;
private $id_Cat;
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
 * Get the value of id_Cat
 */ 
public function getId_Cat()
{
return $this->id_Cat;
}

/**
 * Set the value of id_Cat
 *
 * @return  self
 */ 
public function setId_Cat($id_Cat)
{
$this->id_Cat = $id_Cat;

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