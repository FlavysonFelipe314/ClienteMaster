<?php

use App\Repositories\SystemRepositoryMysql;
use App\Services\AuthService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE);
$userInfo = $AuthService->checkToken();

$systemRepository = new SystemRepositoryMysql($pdo);

$system = $systemRepository->findById($userInfo->getId());

?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= SYSTEM_NAME?></title>

    <link rel="stylesheet" href="<?= BASE?>/src/styles/vendor/reset.css" />
    <link rel="stylesheet" href="<?= BASE?>/src/styles/global.css" />

    <link rel="stylesheet" href="src/styles/components/buttons.css" />
    <link rel="stylesheet" href="src/styles/components/inputs.css" />
    <link rel="stylesheet" href="src/styles/components/form.css" />
    <link rel="stylesheet" href="src/styles/components/search.css" />
    <link rel="stylesheet" href="src/styles/components/infoBar.css" />
    <link rel="stylesheet" href="src/styles/components/pagination.css" />
    <link rel="stylesheet" href="src/styles/components/modal.css" />
    <link rel="stylesheet" href="src/styles/components/cards.css" />
    <link rel="stylesheet" href="src/styles/components/selectCupom.css" />

    <link rel="stylesheet" href="<?= BASE?>/src/styles/layouts/sideMenu.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" hr ef="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"
    />

    <script
      src="https://kit.fontawesome.com/cacd8cf69e.js"
      crossorigin="anonymous"
    ></script>

    <style>
      :root{
        --primary-background: <?= $system->background_color	?>;
        --primary-black: <?= $system->primary_color	?>;
        --primary-orange: <?= $system->secondary_color	?>;
      }
    </style>
  </head>
  <body>
    <aside id="menu-bar">
      <div class="top">
        <div class="logo">
          <img src="<?= BASE_DIR?>/uploads/logos/<?= $system->logo?>" alt="" />
          <span class="material-symbols-outlined close"> close </span>
        </div>

        <form action="<?= BASE?>/search" id="search" class="search" method="GET">
          <input type="text" name="query" placeholder="Pesquisar..." />
          <button type="submit">
            <span class="material-symbols-outlined"> search </span>
          </button>
        </form>

        <nav>
          <ul>
            <li>
              <a href="<?= BASE?>/" class="menu-options <?= ($activeMenu === "inicio") ? "selected" : "" ?>">
                <span class="material-symbols-outlined"> home </span>
                Inicio
              </a>
            </li>
            <li>
              <a href="<?= BASE?>/clientes" class="menu-options  <?= ($activeMenu === "clientes") ? "selected" : "" ?>">
                <span class="material-symbols-outlined"> groups </span>
                Clientes
              </a>
            </li>
            <li>
              <a href="<?= BASE?>/aniversariantes" class="menu-options <?= ($activeMenu === "aniversariantes") ? "selected" : "" ?>">
                <span class="material-symbols-outlined">
                  featured_seasonal_and_gifts
                </span>
                Aniversáriantes
              </a>
            </li>
            <li>
              <a href="<?= BASE?>/cupons" class="menu-options <?= ($activeMenu === "cupons") ? "selected" : "" ?>">
                <span class="material-symbols-outlined">
                  confirmation_number
                </span>
                Cupons
              </a>
            </li>
            <li>
              <a href="<?= BASE?>/vendas" class="menu-options <?= ($activeMenu === "vendas") ? "selected" : "" ?>">
                <span class="material-symbols-outlined">
                  currency_exchange
                </span>
                Vendas
              </a>
            </li>
            <!-- <li>
              <a href="<?= BASE?>/relatórios" class="menu-options <?= ($activeMenu === "relatorios") ? "selected" : "" ?>">
                <span class="material-symbols-outlined">
                  record_voice_over
                </span>
                Relatórios
              </a>
            </li> -->
          </ul>
        </nav>
      </div>
      <div class="bottom">
        <div class="options">
          <a href="<?= BASE?>/perfil" class="option">
            <i class="fa-regular fa-user"></i>
            <p>perfil</p>
          </a>
          <a href="<?= BASE?>/configuracoes" class="option">
            <i class="fa-solid fa-gear"></i>
            <p>Contig</p>
          </a>
        </div>
        <a href="<?= BASE_DIR?>/Actions/logoutAction" class="logout option">
          <i class="fa-solid fa-arrow-right-from-bracket"></i>
          <p>Sair</p>
        </a>
      </div>
    </aside>

    <aside id="site-body">
      <div class="container">
        <header>
          <img src="<?= BASE?>/src/assets/images/logo.png" alt="" />

          <div class="menu-hamburguer">
            <i class="fa-solid fa-bars"></i>
          </div>

          <form action="<?= BASE?>/search" id="search" class="search" method="GET">
            <input type="text" name="query" placeholder="Pesquisar..." />
            <button type="submit">
              <span class="material-symbols-outlined"> search </span>
            </button>
          </form>

          <a href="<?= BASE?>/perfil" class="avatar">
            <img src="<?= BASE_DIR?>/uploads/avatar/<?= $userInfo->getAvatar()?>" alt="" />
          </a>
        </header>
