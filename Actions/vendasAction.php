<?php

use App\Models\Venda;
use App\Repositories\ClienteRepositoryMysql;
use App\Repositories\VendaRepositoryMysql;
use App\Services\AuthService;
use App\Services\VendaService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE);
$userInfo = $AuthService->checkToken();

$VendaRepository = new VendaRepositoryMysql($pdo);
$VendaService = new VendaService($pdo);

$ClienteRepository = new ClienteRepositoryMysql($pdo);

// Create
if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["action"] == "create")
{
    $id_cliente = filter_input(INPUT_POST, "id_cliente");
    $id_cupom = filter_input(INPUT_POST, "id_cupom");
    $description = filter_input(INPUT_POST, "service", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $total = filter_input(INPUT_POST, "total");

    if($id_cliente && $description && $total){    
        $VendaService->registerVenda($userInfo->getId(), $id_cliente, $id_cupom, $total, $description);
        
        $Cliente = $ClienteRepository->findById($id_cliente, $userInfo->getId());
        
        $ranking = $Cliente->getRanking() + 1;
        $Cliente->setRanking($ranking);
        print_r($Cliente);
        $ClienteRepository->update($Cliente);

        $_SESSION["flash"] = "Venda Cadastrada com Sucesso";
        header("Location: ".BASE."/vendas");
        exit;
    }

    $_SESSION["flash"] = "Preencha Todos os Campos Corretamente";
    header("Location: ".BASE."/cadastrar_venda");
    exit;
}

// Update
if($_SERVER["REQUEST_METHOD"] == "POST"  && $_POST["action"] == "update"){}

// Delete
if($_SERVER["REQUEST_METHOD"] == "GET")
{
    $id = filter_input(INPUT_GET, "id");

    $ClienteId = $VendaRepository->findById($id, $userInfo->getId());

    $Cliente = $ClienteRepository->findById($ClienteId->getIdCliente(), $userInfo->getId());

    $ranking = $Cliente->getRanking() - 1;
    $Cliente->setRanking($ranking);
    $ClienteRepository->update($Cliente);

    $VendaRepository->delete($id, $userInfo->getId());
    $_SESSION["flash"] = "Venda Deletada com Sucesso";
    header("Location: ".BASE."/vendas");
    exit;
}

$_SESSION["flash"] = "Preencha Todos os Campos Corretamente";
header("Location: ".BASE."/editar_venda");
exit;

?>