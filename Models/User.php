<?php

namespace Models;

use Models\UserType;

 class User{
    private $id;
    private $firstName;
    private $lastName;
    private $dni;
    private $email;
    private $phoneNumber;
    private $userType;
    private $username;
    private $password;

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getDni()
    {
        return $this->dni;
    }

    public function setDni($dni): self
    {
        $this->dni = $dni;

        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber($phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getUserType()
    {
        return $this->userType;
    }

    public function setUserType(UserType $userType): self
    {
        $this->userType = $userType;

        return $this;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }
}

?>