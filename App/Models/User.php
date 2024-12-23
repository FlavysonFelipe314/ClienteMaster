<?php

namespace App\Models;

class User
{
    private $id;
    private $name;
    private $email;
    private $password;
    private $avatar;
    private $birthdate;
    private $cpf;
    private $token;
    private $created_at;
    private $updated_at;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }

    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function getBirthdate()
    {
        return $this->birthdate;
    }

    public function getCpf()
    {
        return $this->cpf;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}

?>
