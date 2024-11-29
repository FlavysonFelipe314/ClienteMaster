<?php require_once "../Config/config.php"?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= SYSTEM_NAME?></title>

    <link rel="stylesheet" href="<?= BASE?>/src/styles/vendor/reset.css" />
    <link rel="stylesheet" href="<?= BASE?>/src/styles/global.css" />
    <link rel="stylesheet" href="<?= BASE?>/src/styles/components/buttons.css" />
    <link rel="stylesheet" href="<?= BASE?>/src/styles/components/inputs.css" />
    <link rel="stylesheet" href="<?= BASE?>/src/styles/components/form.css" />
    <link rel="stylesheet" href="<?= BASE?>/src/styles/layouts/formularioUser.css" />
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
  </head>
  <body>
    <section>
      <aside>
        <img src="<?= BASE?>/src/assets/images/logo.png" alt="" />
        <div class="login-text">
          <h1>Bem Vindo<br />de Volta!</h1>
          <h3>Entre na sua Conta Agora Mesmo.</h3>
        </div>
        <div class="actions-login">
          <a href="<?= BASE?>/login"> <button>Entrar</button> </a><br /><br />
          <a href="esqueci.html"> Esqueci Minha Senha </a>
        </div>
      </aside>
      <aside>
        <div class="login-text-light">
          <h1>Entre na sua Conta</h1>
          <h3>Preencha seus Dados</h3>
        </div>
        <form action="<?= BASE_DIR?>/Actions/cadastroAction" method="POST">
            <div class="flashMessages">
                <?php
                    if(!empty($_SESSION["flash"])){
                        echo $_SESSION["flash"];
                        unset($_SESSION["flash"]);
                    }
                ?>
            </div>

          <div class="input-wraper">
            <input type="text" name="name" placeholder="Nome...">
            <label for="nome" class="form-icon">
              <span class="material-symbols-outlined"> person </span>
            </label>
          </div>

          <div class="input-wraper">
            <input type="email" name="email" placeholder="Email...">
            <label for="password" class="form-icon">
              <span class="material-symbols-outlined"> alternate_email </span>
            </label>
          </div>

          <div class="input-wraper">
            <input type="password" name="password" placeholder="Senha..." id="password">
            <label for="password" class="form-icon">
              <span class="material-symbols-outlined"> lock </span>
            </label>
          </div>

          <div class="input-wraper">
            <input type="password" name="confirmPassword" placeholder="Confirmar Senha...">
            <label for="password" class="form-icon">
              <span class="material-symbols-outlined"> lock </span>
            </label>
          </div>

          <div class="input-wraper">
            <input
              type="tel"
              maxlength="14"
              name="cpf"
              id="cpf"
              placeholder="cpf"
            />
            <label for="nome" class="form-icon">
              <span class="material-symbols-outlined"> clinical_notes </span>
            </label>
          </div>

          <div class="input-wraper">
            <input type="text" name="birthdate" placeholder="Nascimento..." id="birthdate">
            <label for="avatar" class="form-icon">
              <span class="material-symbols-outlined"> featured_seasonal_and_gifts </span>
            </label>
          </div>

          <div class="input-wraper submit-button">
            <button type="submit">Entrar</button>
          </div>
        </form>
      </aside>
    </section>

    <script src="<?= BASE?>/src/scripts/shared/inputValidateCadastro.js"></script>
    <script src="https://unpkg.com/imask"></script>

    <script>
        IMask(
            document.getElementById("birthdate"),
            {mask:'00/00/0000'}
        )
    </script>
  </body>
</html>