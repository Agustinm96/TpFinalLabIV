<?php 
namespace Models;

use Models\Chat as Chat;

class ChatMessage {
private Chat $id_Chat;
private $id_ChatMessage;
private $userName;
private $dataTime;
private $msg;


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

/**
 * Get the value of id_ChatMessage
 */ 
public function getId_ChatMessage()
{
return $this->id_ChatMessage;
}

/**
 * Set the value of id_ChatMessage
 *
 * @return  self
 */ 
public function setId_ChatMessage($id_ChatMessage)
{
$this->id_ChatMessage = $id_ChatMessage;

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

/**
 * Get the value of dataTime
 */ 
public function getDataTime()
{
return $this->dataTime;
}

/**
 * Set the value of dataTime
 *
 * @return  self
 */ 
public function setDataTime($dataTime)
{
$this->dataTime = $dataTime;

return $this;
}



/**
 * Get the value of msg
 */ 
public function getMsg()
{
return $this->msg;
}

/**
 * Set the value of msg
 *
 * @return  self
 */ 
public function setMsg($msg)
{
$this->msg = $msg;

return $this;
}
}


?>