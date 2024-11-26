<?php

namespace App\Services;

use App\Models\Visita;
use App\Repositories\VisitaRepositoryMysql;
use PDO;

class VisitaService{
    private $pdo;
    private $VisitaRepository;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
        $this->VisitaRepository = new VisitaRepositoryMysql($this->pdo);
    } 

    public function registerVisita($id_user, $id_cliente, $data_visita, $description){
        $Visita = new Visita;
        $Visita->setIdUser($id_user);
        $Visita->setIdCliente($id_cliente);
        $Visita->setDataVisita($data_visita);
        $Visita->setDescription($description);

        $this->VisitaRepository->create($Visita);
    }
}

?>