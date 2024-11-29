<?php

use App\Repositories\CupomRepositoryMysql;
use App\Services\AuthService;
use App\Services\CupomService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE);
$userInfo = $AuthService->checkToken();

$CupomService = new CupomService($pdo);
$CupomRepository = new CupomRepositoryMysql($pdo);

$id = filter_input(INPUT_GET, "id");
$id_user = filter_input(INPUT_GET, "id_user");

$cupom = $CupomRepository->findById($id, $id_user);

$nome = $cupom->getName();
$total = $cupom->getTotalDiscount();

$array = [
    'error' => '',
    'id' => $id,
    'nome' => $nome,
    'total' => $total,
];

header("Content-type: application/json");
echo json_encode($array);
exit;

?>
