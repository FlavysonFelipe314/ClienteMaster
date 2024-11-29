<?php

use App\Repositories\ClienteRepositoryMysql;
use App\Services\AuthService;
use App\Services\ClienteService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE);
$userInfo = $AuthService->checkToken();

$ClienteService = new ClienteService($pdo);
$ClienteRepository = new ClienteRepositoryMysql($pdo);

$id = filter_input(INPUT_GET, "id");
$id_user = filter_input(INPUT_GET, "id_user");

$cliente = $ClienteRepository->findById($id, $id_user);

$nome = $cliente->getName();
$email = $cliente->getEmail();
$birthdate = date("d/m/Y", strtotime($cliente->getBirthdate()));

$array = [
    'error' => '',
    'id' => $id,
    'nome' => $nome,
    'email' => $email,
    'birthdate' => $birthdate,
];

header("Content-type: application/json");
echo json_encode($array);
exit;

?>
