<?php

namespace App\Services;

use App\Models\System;
use App\Repositories\ClienteRepositoryMysql;
use App\Repositories\CupomRepositoryMysql;
use App\Repositories\SystemRepositoryMysql;
use App\Repositories\UserRepositoryMysql;
use PDO;

class MailService{
    private $base;
    private $pdo; 
    private $CupomRepository;
    private $UserRepository;
    private $ClienteRepository;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
        $this->CupomRepository = new CupomRepositoryMysql($this->pdo);
        $this->UserRepository = new UserRepositoryMysql($this->pdo);
        $this->ClienteRepository = new ClienteRepositoryMysql($this->pdo);
    }

    public function sendCupom($to, $from, $cupom)
    {
        
        $emailTo = $this->ClienteRepository->findById($to, $from);
        $cupomData = $this->CupomRepository->findById($cupom, $from);
        $system = new SystemRepositoryMysql($this->pdo);
        $name = $system->findById($from);

        $subject = $name->business_name." - CUPOM DE DESCONTO";
        $total = ($cupomData->getTypeDiscount() == "%") ? number_format($cupomData->getTotalDiscount(), 0, ".", " ") : str_replace(".", ",",  $cupomData->getTotalDiscount());
        $message = "<h1>".$emailTo->getName()."! Você recebeu um cupom de desconto de: $total".$cupomData->getTypeDiscount()." 
            </h1><br><h3> Para usar como quiser nos serviços de ". $name->business_name ." <br> 
            Utilize o Cupom: ". $cupomData->getName() . ", Para obter o Desconto!</h3>";
    
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8" . "\r\n";
        $headers .= "From: ".$from . "\r\n";
    
        if (mail($emailTo->getEmail(), $subject, $message, $headers)) {
            return true;
        } else {
            return false;
        }
    }
    
}

?>