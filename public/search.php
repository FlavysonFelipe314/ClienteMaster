<?php

use App\Repositories\CupomRepositoryMysql;
use App\Services\AuthService;
use App\Services\ClienteService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE);
$ClienteService = new ClienteService($pdo);

$query = filter_input(INPUT_GET, "query");

$userInfo = $AuthService->checkToken();
$data = $ClienteService->search($query, $userInfo->getId());



$CupomRepository = new CupomRepositoryMysql($pdo);
$dataCupom = $CupomRepository->findAll($userInfo->getId());


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
        <h1 class="title-topic"><?= $data ? count($data) : 0?> Resultado(s)</h1>
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
                            <h2><?= $item->total?></h2>
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


<?php include_once "../Partials/footer.php"?>
