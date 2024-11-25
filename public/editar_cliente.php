<?php

use App\Repositories\ClienteRepositoryMysql;
use App\Services\AuthService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE);
$userInfo = $AuthService->checkToken();

$id = filter_input(INPUT_GET, "id");

$ClienteRepository = new ClienteRepositoryMysql($pdo);
$data = $ClienteRepository->findById($id, $userInfo->getId());

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
    <form action="<?= BASE_DIR?>/Actions/ClientesAction" method="POST" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Nome..." value="<?= $data->getName()?>"><br>
        <input type="email" name="email" placeholder="email..." value="<?= $data->getEmail()?>"><br>
        <input type="text" name="birthdate" placeholder="nascimento..." value="<?= date("d/m/Y", strtotime($data->getBirthdate()))?>"><br>
        <input type="file" name="avatar" placeholder="Avatar..." accept="image/png, image/jpg, image/jpeg"><br>
        <button type="submit" name="action" value="update">Entrar</button>
    </form>
</body>
</html>