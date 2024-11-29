<?php

namespace App\Models;

class Cliente
{
    private $id;
    private $id_user;
    private $name;
    private $email;
    private $avatar;
    private $birthdate;
    private $ranking;
    private $created_at;
    private $updated_at;
    public $total;
    public $visitas;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;
    }

    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }

    public function setRanking($ranking)
    {
        $this->ranking = $ranking;
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

    public function getIdUser()
    {
        return $this->id_user;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function getBirthdate()
    {
        return $this->birthdate;
    }

    public function getRanking()
    {
        return $this->ranking;
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
