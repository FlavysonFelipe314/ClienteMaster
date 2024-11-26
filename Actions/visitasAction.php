<?php

use App\Repositories\VisitaRepositoryMysql;
use App\Services\AuthService;
use App\Services\VisitaService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE);
$userInfo = $AuthService->checkToken();

$VisitaRepository = new VisitaRepositoryMysql($pdo);
$VisitaService = new VisitaService($pdo);

// Create
if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["action"] == "create")
{
    $id_client = filter_input(INPUT_POST, "id_client");
    $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $dataVisita = filter_input(INPUT_POST, "data_visita");

    if($id_client && $description && $dataVisita){    
        $VisitaService->registerVisita($userInfo->getId(), $id_client, $dataVisita, $description);

        $_SESSION["flash"] = "Visita Cadastrada com Sucesso";
        header("Location: ".BASE."/visitas");
        exit;
    }

    $_SESSION["flash"] = "Preencha Todos os Campos Corretamente";
    header("Location: ".BASE."/cadastrar_visita");
    exit;
}

// Update
if($_SERVER["REQUEST_METHOD"] == "POST"  && $_POST["action"] == "update"){}

// Delete
if($_SERVER["REQUEST_METHOD"] == "GET")
{
    $id = filter_input(INPUT_GET, "id");

    $VisitaRepository->delete($id, $userInfo->getId());
    $_SESSION["flash"] = "visita Deletada com Sucesso";
    header("Location: ".BASE."/visitas");
    exit;
}

$_SESSION["flash"] = "Preencha Todos os Campos Corretamente";
header("Location: ".BASE."/editar_visita");
exit;

?>