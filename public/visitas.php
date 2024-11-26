<?php

use App\Repositories\VisitaRepositoryMysql;
use App\Services\AuthService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE);
$userInfo = $AuthService->checkToken();

$VisitaRepository = new VisitaRepositoryMysql($pdo);
$data = $VisitaRepository->findAll($userInfo->getId());

include_once "../partials/header.php";
?>

<?php
        if(!empty($_SESSION["flash"])){
            echo $_SESSION["flash"];
            unset($_SESSION["flash"]);
        }
    ?>
<h1>Visitas</h1>


<br>
<a href="<?= BASE?>/cadastrar_visita">Cadastrar Visita</a>

<h3>Lista de Visitas</h3>

<?php if(!empty($data)){foreach($data as $item):?>
    <hr>
    <p><?= $item->getCliente()?></p>
    <p><?= $item->getDataVisita()?></p>
    <p><?= $item->getDescription()?></p>
    <a href="<?= BASE?>/editar_visita?id=<?= $item->getId()?>">
        <button>Editar</button>
    </a>
    <form action="<?= BASE_DIR?>/Actions/visitasAction" method="GET">
        <button type="submit" name="id" value="<?= $item->getId()?>">deletar</button>
    </form>
<?php endforeach;}?>