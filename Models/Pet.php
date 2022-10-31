<?php 
namespace Models;

use Models\PetType as PetType;

abstract Class Pet{
private PetType $petType;  // enum de mascota (gato perro cobayo tortuga etc.)
private $name;
private $birthDate;
private $picture; /// VER COMO GUARDAR FOTO
private $observation;
private $IDPET;
private $videoPet;
private $userName;


/**
 * Get the value of name
 */ 
public function getName()
{
return $this->name;
}

/**
 * Set the value of name
 *
 * @return  self
 */ 
public function setName($name)
{
$this->name = $name;

return $this;
}

/**
 * Get the value of birthDate
 */ 
public function getBirthDate()
{
return $this->birthDate;
}

/**
 * Set the value of birthDate
 *
 * @return  self
 */ 
public function setBirthDate($birthDate)
{
$this->birthDate = $birthDate;

return $this;
}

/**
 * Get the value of picture
 */ 
public function getPicture()
{
return $this->picture;
}

/**
 * Set the value of picture
 *
 * @return  self
 */ 
public function setPicture($picture)
{
$this->picture = $picture;

return $this;
}

/**
 * Get the value of observation
 */ 
public function getObservation()
{
return $this->observation;
}

/**
 * Set the value of observation
 *
 * @return  self
 */ 
public function setObservation($observation)
{
$this->observation = $observation;

return $this;
}

/**
 * Get the value of IDPET
 */ 
public function getIDPET()
{
return $this->IDPET;
}

/**
 * Set the value of IDPET
 *
 * @return  self
 */ 
public function setIDPET($IDPET)
{
$this->IDPET = $IDPET;

return $this;
}

/**
 * Get the value of petType
 */ 
public function getPetType()
{
return $this->petType;
}

/**
 * Set the value of petType
 *
 * @return  self
 */ 
public function setPetType(PetType $petType)
{
$this->petType = $petType;

return $this;
}

/**
 * Get the value of videoPET
 */ 
public function getVideoPet()
{
return $this->videoPet;
}

/**
 * Set the value of videoPET
 *
 * @return  self
 */ 
public function setVideoPet($videoPet)
{
$this->videoPet = $videoPet;

return $this;
}

/**
 * Get the value of userName
 */ 
public function getUserName()
{
return $this->userName;
}

/**
 * Set the value of userName
 *
 * @return  self
 */ 
public function setUserName($userName)
{
$this->userName = $userName;

return $this;
}
}


?>