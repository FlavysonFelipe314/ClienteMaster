<?php

namespace App\Models;

class Venda
{
    private $id;
    private $id_user;
    private $id_cliente;
    private $id_cupom;
    private $id_visita;
    private $total;
    private $service;
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

    public function setIdCupom($id_cupom)
    {
        $this->id_cupom = $id_cupom;
    }

    public function setIdVisita($id_visita)
    {
        $this->id_visita = $id_visita;
    }

    public function setTotal($total)
    {
        $this->total = $total;
    }

    public function setService($service)
    {
        $this->service = $service;
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

    public function getIdCupom()
    {
        return $this->id_cupom;
    }

    public function getIdVisita()
    {
        return $this->id_visita;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getService()
    {
        return $this->service;
    }
    
    public function getCliente()
    {
        return $this->cliente;
    }
}

?>
