<?php

namespace App\Services;

use App\Repositories\ClienteRepositoryMysql;
use App\Repositories\CupomRepositoryMysql;
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
        $subject = SYSTEM_NAME." - CUPOM DE DESCONTO DE ".($cupomData->getTypeDiscount() == "%") ? number_format($cupomData->getTotalDiscount(), 0, ".", " ") : str_replace(".", ",",  $cupomData->getTotalDiscount()).$cupomData->getTypeDiscount();
        $message = "<h1>".$emailTo->getName()."! Você recebeu um cupom de desconto de: ".$cupomData->getTotalDiscount().$cupomData->getTypeDiscount()." 
            </h1><br><h3> Para usar como quiser nos serviços de ". SYSTEM_NAME ." <br> 
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