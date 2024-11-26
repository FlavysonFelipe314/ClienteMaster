<?php

use App\Repositories\ClienteRepositoryMysql;
use App\Repositories\CupomRepositoryMysql;
use App\Services\AuthService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE);
$userInfo = $AuthService->checkToken();

$id = filter_input(INPUT_GET, "id");

$ClienteRepository = new ClienteRepositoryMysql($pdo);
$data = $ClienteRepository->findAll($userInfo->getId());

$CupomRepository = new CupomRepositoryMysql($pdo);
$dataCupom = $CupomRepository->findById($id, $userInfo->getId());
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cadastro</title>
</head>
<body>

    <?php
        if(!empty($_SESSION["flash"])){
            echo $_SESSION["flash"];
            unset($_SESSION["flash"]);
        }
    ?>
    <form action="<?= BASE_DIR?>/Actions/cuponsAction" method="POST" enctype="multipart/form-data">

        <label>Selecione a visibilidade do cupom</label><br>
        <select name="id_client" id="">
            <option>Selecione uma Opção</option>
            <option value="all">Todos os Clientes</option>
            <?php if(!empty($data)){foreach($data as $item):?>
                <option value="<?= $item->getId()?>"><?= $item->getName()?></option>
            <?php endforeach;}?>
        </select><br>

        <input type="text" name="name" placeholder="Nome do Cupom..." value="<?= $dataCupom->getName()?>"><br>

        <input type="number" name="total" placeholder="Total de desconto..." value="<?= $dataCupom->getTotalDiscount()?>"><br>

        <label>Selecione o tipo de desconto</label><br>
        <select name="type" id="">
            <option value="">Selecione uma Opção</option>
            <option value="R$">R$</option>
            <option value="%">%</option>
        </select><br>

        <input type="hidden" name="id" value="<?= $id?>"><br>
        <button type="submit" name="action" value="update">Cadastrar</button>
    </form>
</body>
</html>