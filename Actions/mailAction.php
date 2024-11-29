<?php

use App\Repositories\ClienteRepositoryMysql;
use App\Services\AuthService;
use App\Services\ClienteService;
use App\Services\MailService;

require_once "../Config/config.php";

$ClienteService = new ClienteService($pdo);
$ClienteRepository = new ClienteRepositoryMysql($pdo);

$AuthService = new AuthService($pdo, BASE);
$userInfo = $AuthService->checkToken();

$MailService = new MailService($pdo);

$id_user = filter_input(INPUT_POST, "id_user");
$id_cliente = filter_input(INPUT_POST, "id_cliente");
$id_cupom = filter_input(INPUT_POST, "id_cupom");


if($MailService->sendCupom($id_cliente, $id_user, $id_cupom)){
    $_SESSION["flash"] = "Cupom Enviado Com Sucesso";
    header("Location: ".BASE."/clientes");
    exit;
}

$_SESSION["flash"] = "Não Foi Possível Enviar o Cupom, Tente Mais Tarde.";
header("Location: ".BASE."/clientes");
exit;




?>