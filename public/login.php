<?php require_once "../Config/config.php"?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

<?php
        if(!empty($_SESSION["flash"])){
            echo $_SESSION["flash"];
            unset($_SESSION["flash"]);
        }
    ?>
    <form action="<?= BASE_DIR?>/Actions/loginAction" method="POST">
        <input type="email" name="email" placeholder="email..."><br>
        <input type="password" name="password" placeholder="password..."><br>
        <button type="submit">Entrar</button>
    </form>
    <p>Não tem conta? <a href="<?= BASE?>/cadastro">Cadastre-se</a></p>
</body>
</html>