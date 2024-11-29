<?php

use App\Repositories\ClienteRepositoryMysql;
use App\Repositories\CupomRepositoryMysql;
use App\Services\AuthService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE);
$userInfo = $AuthService->checkToken();

$CupomRepository = new CupomRepositoryMysql($pdo);
$dataCupom = $CupomRepository->findAll($userInfo->getId());

$ClienteRepository = new ClienteRepositoryMysql($pdo);
$dataCliente = $ClienteRepository->findAll($userInfo->getId());

$activeMenu = "cupons";

include_once "../partials/header.php";
?>

<?php
    if(!empty($_SESSION["flash"])){
        echo $_SESSION["flash"];
        unset($_SESSION["flash"]);
    }
?>

<head>
    <link rel="stylesheet" href="<?= BASE?>/src/styles/layouts/topics.css" />
</head>

<section class="topic-body">
    <div class="full-title">
    <h1 class="title-topic">Cupons</h1>
    <button onclick="showForm()">Cadastrar Cupom</button>
    </div>

    <div class="topic-list">
        <?php if(!empty($dataCupom)){foreach($dataCupom as $item):?>
            <div class="topic-item">
                <div class="profile-infos">
                    <img src="<?= BASE?>/src/assets/images/default_cupom.png" alt="" />

                    <div class="client-info">
                        <h3><?= $item->getName()?></h3>
                    </div>
                </div>
                <div class="aditional-data">
                    <div class="content-data">
                        <p>Desconto</p>
                        <h2><?= ($item->getTypeDiscount() == "%") ? number_format($item->getTotalDiscount(), 0, ".", " ") : str_replace(".", ",",  $item->getTotalDiscount()) ?><span><?= $item->getTypeDiscount()?></span></h2>
                    </div>
                </div>

                <div class="client-actions">
                    <button onclick="showForm(<?= $item->getId()?>, <?= $userInfo->getId()?>, 'Cupom')" style="background-color: var(--primary-green)">
                        <span class="material-symbols-outlined"> edit </span>
                        Editar
                    </button>

                    <form action="<?= BASE_DIR?>/Actions/cuponsAction" method="GET">
                        <button style="background-color: var(--primary-red)"  type="submit" name="id" value="<?= $item->getId()?>">
                        <span class="material-symbols-outlined"> delete </span>
                        Apagar
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach;}else{echo "Não há Registros Para Mostrar";}?>

    </div>


</section>

<section class="modalForm">
    <div class="box-form">
    <div class="closeModal">
        <span class="material-symbols-outlined" onclick="closeForm()">
        cancel
        </span>
    </div>
    <h1>Cadastrar Cupom</h1>
    <h3>Preencha Todos Os Campos</h3>
    <form action="<?= BASE_DIR?>/Actions/cuponsAction" method="POST" enctype="multipart/form-data">
        <div class="w100-wraper">
            <select name="id_client" id="">
                <option>Selecione uma Opção</option>
                <option value="all">Todos os Clientes</option>
                <?php if(!empty($dataCliente)){foreach($dataCliente as $item):?>
                    <option value="<?= $item->getId()?>"><?= $item->getName()?></option>
                <?php endforeach;}?>
            </select>
        </div>

        <div class="w100-wraper">
            <input type="text" name="name" placeholder="Nome do Cupom..."/>
        </div>

        <div class="w100-wraper">
            <input type="number" step="any" name="total" placeholder="Total de desconto...">
        </div>

        <div class="w100-wraper">
            <select name="type" id="">
                <option value="">Selecione uma Opção</option>
                <option value="R$">R$</option>
                <option value="%">%</option>
            </select>
        </div>
        <br />
        <div class="w100-submit">
        </div>
    </form>
    </div>
</section>


<?php include_once "../Partials/footer.php"?>
