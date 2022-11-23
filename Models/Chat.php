<?php 
namespace Models;

use Models\User as User;

class Chat {
private User $id_Owner; //Mismo nombre que base de datos.
private User $id_Keeper; //Mismo nombre que base de datos.
private $id_Chat;

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
public function setId_Owner(User $id_Owner)
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
public function setId_Keeper(User $id_Keeper)
{
$this->id_Keeper = $id_Keeper;

return $this;
}

/**
 * Get the value of id_Chat
 */ 
public function getId_Chat()
{
return $this->id_Chat;
}

/**
 * Set the value of id_Chat
 *
 * @return  self
 */ 
public function setId_Chat($id_Chat)
{
$this->id_Chat = $id_Chat;

return $this;
}


}

?>