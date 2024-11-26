<?php

use App\Repositories\VendaRepositoryMysql;
use App\Services\AuthService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE);
$userInfo = $AuthService->checkToken();

include_once "../partials/header.php";

$VendaRepository = new VendaRepositoryMysql($pdo);
$data = $VendaRepository->findAll($userInfo->getId());
?>

<?php
        if(!empty($_SESSION["flash"])){
            echo $_SESSION["flash"];
            unset($_SESSION["flash"]);
        }
    ?>
<h1>Vendas</h1>


<br>
<a href="<?= BASE?>/cadastrar_venda">Cadastrar Venda</a>

<h3>Lista de Vendas</h3>

<?php if(!empty($data)){foreach($data as $item):?>
    <hr>
    <p><?= $item->getCliente()?></p>
    <p><?= $item->getTotal()?></p>
    <p><?= $item->getService()?></p>
    <a href="<?= BASE?>/editar_venda?id=<?= $item->getId()?>">
        <button>Editar</button>
    </a>
    <form action="<?= BASE_DIR?>/Actions/vendasAction" method="GET">
        <button type="submit" name="id" value="<?= $item->getId()?>">deletar</button>
    </form>
<?php endforeach;}?>