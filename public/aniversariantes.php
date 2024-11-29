<?php

use App\Repositories\ClienteRepositoryMysql;
use App\Repositories\CupomRepositoryMysql;
use App\Services\AuthService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE);
$userInfo = $AuthService->checkToken();

$ClienteRepository = new ClienteRepositoryMysql($pdo);
$data = $ClienteRepository->findBirthdateMonth($userInfo->getId());

$CupomRepository = new CupomRepositoryMysql($pdo);
$dataCupom = $CupomRepository->findAll($userInfo->getId());


$activeMenu = "aniversariantes";

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
        <h1 class="title-topic">Aniversáriantes</h1>
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
                        <p>Data</p>
                        <h2><?= date("d/m/Y",strtotime($item->getBirthdate()))?></h2>
                    </div>
                </div>

                <div class="client-actions">
                    <button class="cupom" style="background-color: var(--primary-blue)">
                    <span class="material-symbols-outlined">
                        confirmation_number
                    </span>
                    Cupom
                    </button>
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

<?php include_once "../Partials/footer.php"?>
