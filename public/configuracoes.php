<?php

use App\Repositories\SystemRepositoryMysql;
use App\Services\AuthService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE);
$userInfo = $AuthService->checkToken();

$systemRepository = new SystemRepositoryMysql($pdo);

$system = $systemRepository->findById($userInfo->getId());

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
            <h1 class="title-topic">Configurações da Conta</h1>
          </div>
          <br />

          <form action="<?= BASE_DIR ?>/Actions/systemAction" method="POST" enctype="multipart/form-data">
    <div class="w100-wraper">
        <div class="example-blox">
            <p><?= $system->business_name ?></p>
        </div>
        <input 
            type="text" 
            name="business_name" 
            placeholder="Nome da Empresa" 
            value="<?= $system->business_name ?>" 
        />
    </div>

    <div class="w100-wraper">
        <div 
            class="example-blox" 
            style="background-color: var(--primary-black)">
            <img 
                src="<?= BASE_DIR ?>/uploads/logos/<?= $system->logo ?>" 
                alt="Logo da empresa" 
            />
        </div>
        <input 
            type="file" 
            name="logo" 
            placeholder="Escolha uma logo" 
        />
    </div>

    <div class="w100-wraper">
        <div 
            class="example-blox" 
            style="background-color: <?= $system->primary_color ?>">
        </div>
        <input 
            type="color" 
            name="primary_color" 
            placeholder="Cor do Menu" 
            value="<?= $system->primary_color ?>" 
        />
    </div>

    <div class="w100-wraper">
        <div 
            class="example-blox" 
            style="background-color: <?= $system->secondary_color ?>">
        </div>
        <input 
            type="color" 
            name="secondary_color" 
            placeholder="Cor de destaque" 
            value="<?= $system->secondary_color ?>" 
        />
    </div>

    <div class="w100-wraper">
        <div 
            class="example-blox" 
            style="background-color: <?= $system->background_color ?>">
        </div>
        <input 
            type="color" 
            name="background_color" 
            placeholder="Cor de fundo" 
            value="<?= $system->background_color ?>" 
        />
    </div>

    <input 
        type="hidden" 
        name="id" 
        value="<?= $system->id ?>" 
    />

    <div class="w100-button">
        <button type="submit">Salvar</button>
    </div>
</form>

        </section>


<?php include_once "../Partials/footer.php"?>
