<?php

use App\Repositories\CupomRepositoryMysql;
use App\Services\AuthService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE);
$userInfo = $AuthService->checkToken();

$CupomRepository = new CupomRepositoryMysql($pdo);
$data = $CupomRepository->findAll($userInfo->getId());

include_once "../partials/header.php";
?>

<?php
    if(!empty($_SESSION["flash"])){
        echo $_SESSION["flash"];
        unset($_SESSION["flash"]);
    }
?>
<h1>Cupons</h1>


<br>
<a href="<?= BASE?>/cadastrar_cupom">Cadastrar Cupom</a>

<h3>Lista de Cupons</h3>

<?php if(!empty($data)){foreach($data as $item):?>
    <hr>
    <p><?= $item->getName()?></p>
    <a href="<?= BASE?>/editar_cupom?id=<?= $item->getId()?>">
        <button>Editar</button>
    </a>
    <form action="<?= BASE_DIR?>/Actions/cuponsAction" method="GET">
        <button type="submit" name="id" value="<?= $item->getId()?>">deletar</button>
    </form>
<?php endforeach;}?>