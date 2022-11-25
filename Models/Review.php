<?php 
namespace Models;

use Models\User as User;

class Review {
private User $id_Owner; //Mismo nombre que base de datos.
private User $id_Keeper; //Mismo nombre que base de datos.
private $id_Review;
private $score;
private $reviewMsg;
private $switchOwnerKeeper; // valor 0 para owners 1 para keepers.
//ESTE SWITCH TENDRA LA FUNCION DE DETERMINAR SI SE MUESTRA EN LAVISTA DEL OWNER;
//O SE TENDRA EN CONSIDERACION PARA LA CALIFICACION FINAL DEL KEEPER;



/**
 * Get the value of id_Owner
 */ 
public function getId_Owner()
{
return $this->id_Owner;
}

/**
 * Set the value of id_Owner
 *
 * @return  self
 */ 
public function setId_Owner($id_Owner)
{
$this->id_Owner = $id_Owner;

return $this;
}

/**
 * Get the value of id_Keeper
 */ 
public function getId_Keeper()
{
return $this->id_Keeper;
}

/**
 * Set the value of id_Keeper
 *
 * @return  self
 */ 
public function setId_Keeper($id_Keeper)
{
$this->id_Keeper = $id_Keeper;

return $this;
}

/**
 * Get the value of id_Review
 */ 
public function getId_Review()
{
return $this->id_Review;
}

/**
 * Set the value of id_Review
 *
 * @return  self
 */ 
public function setId_Review($id_Review)
{
$this->id_Review = $id_Review;

return $this;
}

/**
 * Get the value of score
 */ 
public function getScore()
{
return $this->score;
}

/**
 * Set the value of score
 *
 * @return  self
 */ 
public function setScore($score)
{
$this->score = $score;

return $this;
}

/**
 * Get the value of reviewMsg
 */ 
public function getReviewMsg()
{
return $this->reviewMsg;
}

/**
 * Set the value of reviewMsg
 *
 * @return  self
 */ 
public function setReviewMsg($reviewMsg)
{
$this->reviewMsg = $reviewMsg;

return $this;
}

/**
 * Get the value of switchOwnerKeeper
 */ 
public function getSwitchOwnerKeeper()
{
return $this->switchOwnerKeeper;
}

/**
 * Set the value of switchOwnerKeeper
 *
 * @return  self
 */ 
public function setSwitchOwnerKeeper($switchOwnerKeeper)
{
$this->switchOwnerKeeper = $switchOwnerKeeper;

return $this;
}
}
?>