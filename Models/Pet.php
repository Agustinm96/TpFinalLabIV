<?php 
namespace Models;

use Models\PetType as PetType;

abstract Class Pet{
private PetType $petType;  //  $id_PetType;
private $name;
private $birthDate;
private $picture; /// VER COMO GUARDAR FOTO
private $observation;
private $id_Pet;
private $videoPet;
private User $id_User;
private $isActive;

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
 * Get the value of id_User
 */ 
public function getId_User()
{
return $this->id_User;
}

/**
 * Set the value of id_User
 *
 * @return  self
 */ 
public function setId_User($id_User)
{
$this->id_User = $id_User;

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

/**
 * Get the value of isActive
 */ 
public function getIsActive()
{
return $this->isActive;
}

/**
 * Set the value of isActive
 *
 * @return  self
 */ 
public function setIsActive($isActive)
{
$this->isActive = $isActive;

return $this;
}
}


?>