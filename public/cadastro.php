<?php require_once "../Config/config.php"?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cadastro</title>
</head>
<body>

    <?php
        if(!empty($_SESSION["flash"])){
            echo $_SESSION["flash"];
            unset($_SESSION["flash"]);
        }
    ?>
    <form action="<?= BASE_DIR?>/Actions/cadastroAction" method="POST">
        <input type="text" name="name" placeholder="Nome..."><br>
        <input type="email" name="email" placeholder="email..."><br>
        <input type="text" name="birthdate" placeholder="nascimento..."><br>
        <input type="text" name="cpf" placeholder="cpf..."><br>
        <input type="password" name="password" placeholder="Senha..."><br>
        <input type="password" name="confirmPassword" placeholder="Confirmar Senha..."><br>
        <button type="submit">Entrar</button>
    </form>
    <p>Não tem conta? <a href="<?= BASE?>/cadastro">Cadastre-se</a></p>
</body>
</html>