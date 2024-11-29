<?php

use App\Repositories\ClienteRepositoryMysql;
use App\Repositories\CupomRepositoryMysql;
use App\Repositories\VisitaRepositoryMysql;
use App\Services\AuthService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE);
$userInfo = $AuthService->checkToken();

$ClienteRepository = new ClienteRepositoryMysql($pdo);
$data = $ClienteRepository->findAll($userInfo->getId());

$CupomRepository = new CupomRepositoryMysql($pdo);
$dataCupom = $CupomRepository->findAll($userInfo->getId());
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
    <form action="<?= BASE_DIR?>/Actions/vendasAction" method="POST">

        <label>Cliente Comprador</label><br>
        <select name="id_cliente" id="">
            <option>Selecione uma Opção</option>
            <?php if(!empty($data)){foreach($data as $item):?>
                <option value="<?= $item->getId()?>"><?= $item->getName()?></option>
            <?php endforeach;}?>
        </select><br>

        <label>Cupom Utilizado</label><br>
        <select name="id_cupom" id="">
            <option>Selecione uma Opção</option>
            <option value="0">Nenhum Cupom Foi Utilizado</option>
            <?php if(!empty($dataCupom)){foreach($dataCupom as $item):?>
                <option value="<?= $item->getId()?>"><?= $item->getName()?></option>
            <?php endforeach;}?>
        </select><br>

        <br>

        <button type="submit" name="action" value="create">Cadastrar</button>
    </form>
</body>
</html>