<?php

use App\Services\AuthService;
use App\Services\UserService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE); 
$UserService = new UserService($pdo);

$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$birthdate = filter_input(INPUT_POST, "birthdate");
$cpf = filter_input(INPUT_POST, "cpf");
$password = filter_input(INPUT_POST, "password");
$confirmPassword = filter_input(INPUT_POST, "confirmPassword"); 

if($name && $email && $password && $confirmPassword && $cpf && $birthdate)
{

    if($password != $confirmPassword)
    {
        $_SESSION["flash"] = "As senhas não batem";
        header("Location: ".BASE."/cadastro");
        exit;
    }

    $birthdate = explode("/", $birthdate);
    if(count($birthdate) != 3)
    {
        $_SESSION["flash"] = "Data de Nascimento Inválida";
        header("Location: ".BASE."/cadastro");
        exit;
    }

    $birthdate = $birthdate[2]."-".$birthdate[1]."-".$birthdate[0];
    if(strtotime($birthdate) === false)
    {
        $_SESSION["flash"] = "Data de Nascimento Inválida";
        header("Location: ".BASE."/cadastro");
        exit;
    }

    if($UserService->emailExists($email) === false && $UserService->cpfExists($cpf) === false)
    {
        $AuthService->registerUser($name, $email, $password, $birthdate, $cpf);

        $_SESSION["flash"] = "Login Realizado Com Sucesso";
        header("Location: ".BASE);
        exit;
    }else{
        $_SESSION["flash"] = "O email e/ou CPF já estão em uso";
        header("Location: ".BASE."/cadastro");
        exit;
    }
}

$_SESSION["flash"] = "Preencha Todos os Campos Corretamente";
header("Location: ".BASE."/cadastro");
exit;

?>