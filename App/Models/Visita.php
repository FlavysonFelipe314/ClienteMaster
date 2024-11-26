<?php

namespace App\Models;

class Visita
{
    private $id;
    private $id_user;
    private $id_cliente;
    private $data_visita;
    private $description;
    private $cliente;
    // Setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }

    public function setIdCliente($id_cliente)
    {
        $this->id_cliente = $id_cliente;
    }

    public function setDataVisita($data_visita)
    {
        $this->data_visita = $data_visita;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setCliente($cliente)
    {
        $this->cliente = $cliente;
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

    public function getIdCliente()
    {
        return $this->id_cliente;
    }

    public function getDataVisita()
    {
        return $this->data_visita;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getCliente()
    {
        return $this->cliente;
    }
}

?>
