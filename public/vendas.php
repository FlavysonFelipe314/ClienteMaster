<?php

use App\Repositories\ClienteRepositoryMysql;
use App\Repositories\CupomRepositoryMysql;
use App\Repositories\VendaRepositoryMysql;
use App\Services\AuthService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE);
$userInfo = $AuthService->checkToken();

$VendaRepository = new VendaRepositoryMysql($pdo);
$data = $VendaRepository->findAll($userInfo->getId());

$ClienteRepository = new ClienteRepositoryMysql($pdo);
$dataCliente = $ClienteRepository->findAll($userInfo->getId());

$CupomRepository = new CupomRepositoryMysql($pdo);
$dataCupom = $CupomRepository->findAll($userInfo->getId());

$activeMenu = "vendas";

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
    <h1 class="title-topic">Vendas</h1>
    <button onclick="showForm()">Cadastrar Venda</button>
    </div>

    <div class="topic-list">
        <?php if(!empty($data)){foreach($data as $item):?>
            <div class="topic-item">
                <div class="profile-infos">
                    <img src="<?= BASE_DIR?>/uploads/avatar/<?= $item->getAvatar()?>" alt="" />
                    <div class="client-info">
                        <h3><?= $item->getCliente()?></h3>
                        <p><?= $item->email?></p>
                    </div>
                </div>

                    <div class="aditional-data">
                        <div class="content-data">
                            <p>Total Gasto</p>
                            <h2><?= $item->getTotal() ? str_replace(".", ",", $item->getTotal()) : "0"?></h2>
                        </div>
                    </div>

                    <div class="client-actions">
                    <button class="cupom" style="background-color: var(--primary-blue)">
                    <span class="material-symbols-outlined">
                            confirmation_number
                        </span>
                        Cupom
                        </button>

                    <form action="<?= BASE_DIR?>/Actions/vendasAction" method="GET">
                        <button style="background-color: var(--primary-red)"  type="submit" name="id" value="<?= $item->getId()?>">
                        <span class="material-symbols-outlined"> delete </span>
                        Apagar
                        </button>
                    </form>

                    <div class="modalCupom">
                    <form action="<?= BASE_DIR?>/Actions/mailAction" method="POST" class="selectCupom">
                    <div class="closeModal">
                        <span class="material-symbols-outlined closeCupom">
                        cancel
                        </span>
                    </div>
                    <h1>Cadastrar Cliente</h1>
                    <input type="hidden" name="id_cliente" value="<?= $item->getId()?>">
                    <input type="hidden" name="id_user" value="<?= $userInfo->getId()?>">
                    <div class="w100-wraper">
                        <select name="id_cupom" id="">
                            <option>Selecione um Cupom</option>s
                            <?php if(!empty($dataCupom)){foreach($dataCupom as $item):?>
                                <option value="<?= $item->getId()?>"><?= $item->getName()?></option>
                            <?php endforeach;}?>
                        </select>
                    </div>
                    <div class="w100-button">
                        <button type="submit">Enviar</button>
                    </div>
                </form>
                    </div>
                    
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
    <h1>Cadastrar Venda</h1>
    <h3>Preencha Todos Os Campos</h3>
    <form action="<?= BASE_DIR?>/Actions/vendasAction" method="POST" enctype="multipart/form-data">
        <div class="w100-wraper">
            <select name="id_cliente" id="">
                <option>Selecione o Cliente</option>
                <?php if(!empty($dataCliente)){foreach($dataCliente as $item):?>
                    <option value="<?= $item->getId()?>"><?= $item->getName()?></option>
                <?php endforeach;}?>
            </select>
        </div>

        <div class="w100-wraper">
            <select name="id_cupom" id="">
                <option>Selecione um Cupom</option>
                <option value="0">Nenhum Cupom Foi Utilizado</option>
                <?php if(!empty($dataCupom)){foreach($dataCupom as $item):?>
                    <option value="<?= $item->getId()?>"><?= $item->getName()?></option>
                <?php endforeach;}?>
            </select>
        </div>

        <div class="w100-wraper">
            <input type="number" step="any" name="total" placeholder="total da venda...">
        </div>

        <div class="w100-wraper">
            <textarea name="service" placeholder="Descrição da venda..." id=""></textarea>
        </div>
        <br />

        <div class="w100-submit">
        </div>
    </form>
    </div>
</section>


<?php include_once "../Partials/footer.php"?>
