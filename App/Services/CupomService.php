<?php

namespace App\Services;

use App\Models\Cupom;
use App\Repositories\CupomRepositoryMysql;
use PDO;

class CupomService{
    private $pdo;
    private $CupomRepository;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
        $this->CupomRepository = new CupomRepositoryMysql($this->pdo);
    } 

    public function resgisterCupom($id_client, $name, $total, $type, $id_user)
    { 
        $Cupom = new Cupom;
        $Cupom->setIdClient($id_client);
        $Cupom->setName($name);
        $Cupom->setTotalDiscount($total);
        $Cupom->setTypeDiscount($type);
        $Cupom->setIdUser($id_user);

        $this->CupomRepository->create($Cupom);
    }
}

?>