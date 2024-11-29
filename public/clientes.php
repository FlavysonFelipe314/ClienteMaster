<?php

use App\Repositories\ClienteRepositoryMysql;
use App\Repositories\CupomRepositoryMysql;
use App\Services\AuthService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE);
$userInfo = $AuthService->checkToken();

$ClienteRepository = new ClienteRepositoryMysql($pdo);
$data = $ClienteRepository->findAll($userInfo->getId());

$CupomRepository = new CupomRepositoryMysql($pdo);
$dataCupom = $CupomRepository->findAll($userInfo->getId());

$activeMenu = "clientes";

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
    <h1 class="title-topic">Lista de Clientes</h1>
    <button onclick="showForm()">Cadastrar Cliente</button>
    </div>

    <div class="topic-list">
        <?php if(!empty($data)){foreach($data as $item):?>
            
            <div class="topic-item">
                <div class="profile-infos">
                    <img src="<?= BASE_DIR?>/uploads/avatar/<?= $item->getAvatar()?>" alt="" />
                    <div class="client-info">
                        <h3><?= $item->getName()?></h3>
                        <p><?= $item->getEmail()?></p>
                    </div>
                </div>

                <div class="aditional-data">
                    <div class="content-data">
                        <p>Total Gasto</p>
                        <h2><?= $item->total ? str_replace(".", ",", $item->total) : "0"?></h2>
                    </div>
                </div>

                <div class="client-actions">
                    <button class="cupom" style="background-color: var(--primary-blue)">
                    <span class="material-symbols-outlined">
                        confirmation_number
                    </span>
                    Cupom
                    </button>

                    <button onclick="showForm(<?= $item->getId()?>, <?= $userInfo->getId()?>, 'Cliente')" style="background-color: var(--primary-green)">
                    <span class="material-symbols-outlined"> edit </span>
                    Editar
                    </button>

                    <form action="<?= BASE_DIR?>/Actions/clientesAction" method="GET">
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
    <h1>Cadastrar Cliente</h1>
    <h3>Preencha Todos Os Campos</h3>
    <form action="<?= BASE_DIR?>/Actions/clientesAction" method="POST" enctype="multipart/form-data">
        <div class="w100-wraper">
        <input type="text" name="name" placeholder="Nome do Cliente..." />
        </div>

        <div class="w100-wraper">
        <input
            type="email"
            name="email"
            placeholder="Email do Cliente..."
        />
        </div>

        <div class="w100-wraper">
        <input type="file" name="avatar" />
        </div>

        <div class="w100-wraper">
        <input
            type="text"
            name="birthdate"
            placeholder="Data de Nascimento..."
        />
        </div>
        <br />

        <div class="w100-submit">
        </div>
    </form>
    </div>
</section>


<?php include_once "../Partials/footer.php"?>
