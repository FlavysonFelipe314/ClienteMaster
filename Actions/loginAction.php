<?php

use App\Services\AuthService;
use App\Services\UserService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE); 
$UserService = new UserService($pdo);


$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, "password");

if($email && $password)
{
    if($UserService->emailExists($email)){
        if($AuthService->validateLogin($email, $password)){
            $_SESSION["flash"] = "Login Realizado com Sucesso";
            header("Location: ".BASE);
            exit;    
        }

        $_SESSION["flash"] = "Dados incorretos, tente novamente";
        header("Location: ".BASE);
        exit;
    }

    $_SESSION["flash"] = "Não existe uma conta com este email";
    header("Location: ".BASE."/login");
    exit;
}

$_SESSION["flash"] = "Preencha Todos os Campos Corretamente";
header("Location: ".BASE."/login");
exit;

?>