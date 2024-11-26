<?php

namespace App\Models;

class Cupom
{
    private $id;
    private $id_user;
    private $id_client;
    private $name;
    private $total_discount;
    private $type_discount;

    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }

    public function setIdClient($id_client)
    {
        $this->id_client = $id_client;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setTotalDiscount($total_discount)
    {
        $this->total_discount = $total_discount;
    }

    public function setTypeDiscount($type_discount)
    {
        $this->type_discount = $type_discount;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }

    public function getIdUser()
    {
        return $this->id_user;
    }

    public function getIdClient()
    {
        return $this->id_client;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getTotalDiscount()
    {
        return $this->total_discount;
    }

    public function getTypeDiscount()
    {
        return $this->type_discount;
    }
}

?>
