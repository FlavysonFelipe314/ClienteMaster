<?php

use App\Repositories\ClienteRepositoryMysql;
use App\Services\AuthService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE);
$userInfo = $AuthService->checkToken();

$ClienteRepository = new ClienteRepositoryMysql($pdo);
$data = $ClienteRepository->findAll($userInfo->getId());


include_once "../partials/header.php";
?>

<?php
        if(!empty($_SESSION["flash"])){
            echo $_SESSION["flash"];
            unset($_SESSION["flash"]);
        }
    ?>
<h1>Clientes</h1>


<br>
<a href="<?= BASE?>/cadastrar_cliente">Cadastrar Cliente</a>

<h3>Lista de clientes</h3>

<?php if(!empty($data)){foreach($data as $item):?>
    <hr>
    <img src="<?= BASE_DIR?>/uploads/avatar/<?= $item->getAvatar()?>" width="100" alt="">
    <p><?= $item->getName()?></p>
    <p><?= $item->getEmail()?></p>
    <a href="<?= BASE?>/editar_cliente?id=<?= $item->getId()?>">
        <button>Editar</button>
    </a>
    <form action="<?= BASE_DIR?>/Actions/ClientesAction" method="GET">
        <button type="submit" name="id" value="<?= $item->getId()?>">deletar</button>
    </form>
<?php endforeach;}?>