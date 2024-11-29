<?php

use App\Repositories\ClienteRepositoryMysql;
use App\Repositories\VendaRepositoryMysql;
use App\Services\AuthService;
use App\Services\ClienteService;
use App\Services\CupomService;
use App\Services\VendaService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE);
$ClienteService = new ClienteService($pdo);
$VendaService = new VendaService($pdo);
$CupomService = new CupomService($pdo);

$userInfo = $AuthService->checkToken();

$ClienteRepository = new ClienteRepositoryMysql($pdo);
$clientes = $ClienteRepository->findAll($userInfo->getId());
$top10 = $ClienteRepository->findTop10($userInfo->getId());


$VendaRepository = new VendaRepositoryMysql($pdo);
$vendas = $VendaRepository->findAll($userInfo->getId());


$activeMenu = "inicio";

include_once "../partials/header.php";
?>

<?php
    if(!empty($_SESSION["flash"])){
        echo $_SESSION["flash"];
        unset($_SESSION["flash"]);
    }
?>

<head>
    <link rel="stylesheet" href="<?= BASE?>/src/styles/layouts/home.css" />
</head>

<section class="info-cards">
    <h1 class="title-topic">Bem Vindo, <?= $userInfo->getName()?></h1>

    <div class="cards-content">
    <a href="<?= BASE?>/clientes"  class="card-wraper">
        <div class="card-single">
        <div class="top-card">
            <p>Clientes</p>
            <span class="material-symbols-outlined"> monitoring </span>
        </div>
        <h1><?= $ClienteService->countTotalClientes($userInfo->getId($userInfo->getId()))?></h1>
        </div>
    </a>

    <a href="<?= BASE?>/cupons"  class="card-wraper">
        <div class="card-single">
        <div class="top-card">
            <p>Cupons Ativos</p>
            <span class="material-symbols-outlined"> confirmation_number </span>
        </div>
        <h1><?= $CupomService->countTotalCupons($userInfo->getId($userInfo->getId()))?></h1>
        </div>
    </a>

    <a href="<?= BASE?>/aniversariantes"  class="card-wraper">
        <div class="card-single">
        <div class="top-card">
            <p>Aniversáriantes</p>
            <span class="material-symbols-outlined">featured_seasonal_and_gifts</span>
        </div>
        <h1><?= $ClienteService->countTotalBirthdate($userInfo->getId($userInfo->getId())) ?? 0?></h1>
        </div>
    </a>

    <a href="<?= BASE?>/vendas"  class="card-wraper">
        <div class="card-single">
        <div class="top-card">
            <p>Faturamento</p>
            <span class="material-symbols-outlined"> attach_money </span>
        </div>
        <h1><?= $VendaService->getFaturamento($userInfo->getId())?></h1>
        </div>
    </a>
    </div>
</section>

<section class="content-home">
    <aside>
    <div class="info-boxes">
        <div class="box-wraper">
            <div class="box-single">
                <h3 class="title-box">Ultimos Clientes Cadastrados</h3>

                <div class="user-info-content">
                    <?php if(!empty($clientes)){foreach($clientes as $cliente):?>
                        <a href="<?= BASE?>/search?query=<?= $cliente->getName()?>" class="user-info">
                            <img src="<?= BASE_DIR?>/uploads/avatar/<?= $cliente->getAvatar()?>" alt="" />
                            <div class="data-user">
                            <h3><?= $cliente->getName()?></h3>
                            <p><?= $cliente->getEmail()?></p>
                            </div>
                        </a>
                    <?php endforeach;}else{echo "Não há Registros Para Exibir";}?>
                </div>
            </div>
        </div>

        <div class="box-wraper">
            <div class="box-single">
                <h3 class="title-box">Ultimas Vendas Realizadas</h3>

                <div class="user-info-content">
                    <?php if(!empty($vendas)){foreach($vendas as $venda):?>
                        <a href="<?= BASE?>/search?query=<?= $venda->getCliente()?>" class="user-info">
                            <img src="<?= BASE_DIR?>/uploads/avatar/<?= $venda->getAvatar()?>" alt="" />
                            <div class="data-user">
                                <h3><?= $venda->getCliente()?></h3>
                                <p><?= $venda->getTotal()?></p>
                            </div>
                        </a>
                    <?php endforeach;}else{echo "Não há Registros Para Exibir";}?>
                </div>

            </div>
        </div>
    </div>

    <!-- <div class="chart-box">
        <div>
        <canvas class="myChart"></canvas>
        </div>
    </div> -->
    </aside>
    <aside>
    <div class="box-single">
        <h3 class="title-box">Top 10 Clientes</h3>

        <div class="user-info-content">
            <?php if(!empty($top10)){foreach($top10 as $top):?>
                <a href="<?= BASE?>/search?query=<?= $top->getName()?>" class="user-info">
                    <img src="<?= BASE_DIR?>/uploads/avatar/<?= $top->getAvatar()?>" alt="" />
                    <div class="data-user">
                    <h3><?= $top->getName()?></h3>
                    <p><?= $top->getEmail()?></p>
                    </div>
                </a>
            <?php endforeach;}else{echo "Não há Registros Para Exibir";}?>
        </div>
    </div>
    </aside>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  var ctx = document.getElementsByClassName("myChart");

  const myChart = new Chart(ctx, {
    type: "bar",
    data: {
      labels: [
        "jan",
        "fev",
        "mar",
        "abr",
        "mai",
        "jun",
        "jul",
        "ago",
        "set",
        "out",
        "nov",
        "dez",
      ],
      datasets: [
        {
          label: "Balanço Financeiro",
          data: [
            1500, 500, 1750, 1200, 992, 150, 1000, 1750, 1600, 952, 110,
            150,
          ],
          borderWidth: 2,
          borderColor: "transparent",
          backgroundColor: "#e88b16",
        },
      ],
    },
  });
</script>

<?php include_once "../Partials/footer.php"?>