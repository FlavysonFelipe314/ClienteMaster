<?php

use App\Repositories\CupomRepositoryMysql;
use App\Repositories\VendaRepositoryMysql;
use App\Services\AuthService;
use App\Services\ClienteService;
use App\Services\CupomService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE);
$ClienteService = new ClienteService($pdo);
$CupomService = new CupomService($pdo);

$query = filter_input(INPUT_GET, "query");

$userInfo = $AuthService->checkToken();
$data = $ClienteService->getAllClientes($userInfo->getId());


$VendaRepository = new VendaRepositoryMysql($pdo);
$data = $VendaRepository->findAll($userInfo->getId());

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
    <link rel="stylesheet" href="<?= BASE?>/src/styles/layouts/perfil.css" />
</head>

<section class="topic-body">
          <div class="profile">
            <div class="user">
              <img src="<?= BASE_DIR?>/uploads/avatar/<?= $userInfo->getAvatar()?>" alt="" />
              <div class="infos">
                <h1><?= $userInfo->getName()?></h1>
                <h2><?= $userInfo->getEmail()?></h2>
              </div>
            </div>
            <div class="option">
                <button onclick="showForm(999, <?= $userInfo->getId()?>, 'User')">Editar Perfil</button>
            </div>
          </div>
          <section class="info-cards">
            <div class="cards-content">
              <div class="card-wraper">
                <div class="card-single">
                  <div class="top-card">
                    <p>Clientes</p>
                    <span class="material-symbols-outlined"> monitoring </span>
                  </div>
                  <h1><?= $ClienteService->countTotalClientes($userInfo->getId())?></h1>
                </div>
              </div>

              <div class="card-wraper">
                  <div class="card-single"  style="background-color:var(--primary-blue);">
                    <div class="top-card">
                        <p>Aniversáriantes</p>
                        <span class="material-symbols-outlined">featured_seasonal_and_gifts</span>
                    </div>
                    <h1><?= $ClienteService->countTotalBirthdate($userInfo->getId($userInfo->getId())) ?? 0?></h1>
                  </div>
              </div>
            </div>
          </section>

          <div class="full-title">
            <h1 class="title-topic">Ultimas Clientes Adicionados</h1>
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
          </div>
        </section>

        <section class="modalForm">
    <div class="box-form">
    <div class="closeModal">
        <span class="material-symbols-outlined" onclick="closeForm()">
        cancel
        </span>
    </div>
    <h1>Editar Perfil</h1>
    <h3>Preencha Todos Os Campos</h3>
    <form action="<?= BASE_DIR?>/Actions/editAction" method="POST" enctype="multipart/form-data">
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
   
        <div class="w100-wraper">
        <input
            type="password"
            name="password"
            placeholder="Senha..."
        />
        </div>
        <div class="w100-wraper">
        <input
            type="password"
            name="confirmPassword"
            placeholder="Confirmar Senha..."
        />
        </div>     <br />

        <div class="w100-submit">
        </div>
    </form>
    </div>
</section>

<?php include_once "../Partials/footer.php"?>
