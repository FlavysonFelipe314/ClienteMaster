<?php

use App\Repositories\CupomRepositoryMysql;
use App\Services\AuthService;
use App\Services\CupomService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE);
$userInfo = $AuthService->checkToken();

$CupomRepository = new CupomRepositoryMysql($pdo);
$CupomService = new CupomService($pdo);

// Create
if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["action"] == "create")
{
    $id_client = filter_input(INPUT_POST, "id_client");
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $total = filter_input(INPUT_POST, "total");
    $type = filter_input(INPUT_POST, "type");

    if($id_client && $name && $total && $type){    
        $CupomService->resgisterCupom($id_client, $name, $total, $type, $userInfo->getId());

        $_SESSION["flash"] = "Cupom Cadastrado com Sucesso";
        header("Location: ".BASE."/cupons");
        exit;
    }

    $_SESSION["flash"] = "Preencha Todos os Campos Corretamente";
    header("Location: ".BASE."/cadastrar_cupom");
    exit;

}

// Update
if($_SERVER["REQUEST_METHOD"] == "POST"  && $_POST["action"] == "update")
{
    $id = filter_input(INPUT_POST, "id");
    $id_client = filter_input(INPUT_POST, "id_client");
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $total = filter_input(INPUT_POST, "total");
    $type = filter_input(INPUT_POST, "type");

    if($name && $total){   
        
        $Cupom = $CupomRepository->findById($id, $userInfo->getId());
        $Cupom->setName($name);
        $Cupom->setTotalDiscount($total);

        if(!empty($type)){
            $Cupom->setTypeDiscount($type);
        }

        if(!empty($id_client)){
            $Cupom->setIdClient($id_client);
        }


        $CupomRepository->update($Cupom);

        $_SESSION["flash"] = "Cupom Atualizado com Sucesso";
        header("Location: ".BASE."/cupons");
        exit;
    }

    $_SESSION["flash"] = "Preencha Todos os Campos Corretamente";
    header("Location: ".BASE."/cadastrar_cupom");
    exit;
}

// Delete
if($_SERVER["REQUEST_METHOD"] == "GET")
{
    $id = filter_input(INPUT_GET, "id");

    $CupomRepository->delete($id, $userInfo->getId());
    $_SESSION["flash"] = "Cupom Deletado com Sucesso";
    header("Location: ".BASE."/cupons");
    exit;
}

$_SESSION["flash"] = "Solicitação Inválida";
header("Location: ".BASE);
exit;

?>