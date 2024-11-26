<?php

use App\Repositories\ClienteRepositoryMysql;
use App\Repositories\CupomRepositoryMysql;
use App\Services\AuthService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE);
$userInfo = $AuthService->checkToken();

$ClienteRepository = new ClienteRepositoryMysql($pdo);
$data = $ClienteRepository->findAll($userInfo->getId());
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
    <form action="<?= BASE_DIR?>/Actions/visitasAction" method="POST" enctype="multipart/form-data">

        <label>Selecione o Cliente</label><br>
        <select name="id_client" id="">
            <option>Selecione uma Opção</option>
            <?php if(!empty($data)){foreach($data as $item):?>
                <option value="<?= $item->getId()?>"><?= $item->getName()?></option>
            <?php endforeach;}?>
        </select><br>

        <input type="text" name="data_visita" placeholder="Data de visita..."><br>

        <textarea name="description" placeholder="Descrição da visita..." id=""></textarea><br>

        <button type="submit" name="action" value="create">Cadastrar</button>
    </form>
</body>
</html>