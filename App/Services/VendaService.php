<?php

namespace App\Services;

use App\Models\Venda;
use App\Repositories\VendaRepositoryMysql;
use PDO;

class VendaService{
    private $pdo;
    private $VendaRepository;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
        $this->VendaRepository = new VendaRepositoryMysql($this->pdo);
    } 

    public function registerVenda($id_user, $id_cliente, $id_cupom, $total, $service){
        $Venda = new Venda;
        $Venda->setIdUser($id_user);
        $Venda->setIdCliente($id_cliente);
        $Venda->setIdCupom($id_cupom);
        $Venda->setTotal($total);
        $Venda->setService($service);

        $this->VendaRepository->create($Venda);
    }

    public function getFaturamento($id_user){
        $total = $this->VendaRepository->findTotal($id_user);

        $total = (!empty($total)) ? $total : 0;
        return $total;
    }
}

?>