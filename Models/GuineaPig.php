<?php 
namespace Models;

class GuineaPig extends Pet {
private $gender;
private $heno; /// Picture Format
private $id_GuineaPig;
private $id_Pet;



/**
 * Get the value of gender
 */ 
public function getGender()
{
return $this->gender;
}

/**
 * Set the value of gender
 *
 * @return  self
 */ 
public function setGender($gender)
{
$this->gender = $gender;

return $this;
}

/**
 * Get the value of heno
 */ 
public function getHeno()
{
return $this->heno;
}

/**
 * Set the value of heno
 *
 * @return  self
 */ 
public function setHeno($heno)
{
$this->heno = $heno;

return $this;
}

/**
 * Get the value of id_GuineaPig
 */ 
public function getId_GuineaPig()
{
return $this->id_GuineaPig;
}

/**
 * Set the value of id_GuineaPig
 *
 * @return  self
 */ 
public function setId_GuineaPig($id_GuineaPig)
{
$this->id_GuineaPig = $id_GuineaPig;

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