<?php

use App\Repositories\UserRepositoryMysql;
use App\Services\AuthService;
use App\Services\UserService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE);
$userInfo = $AuthService->checkToken();

$UserService = new UserService($pdo);
$UserRepository = new UserRepositoryMysql($pdo);

$id = filter_input(INPUT_GET, "id");
$id_user = filter_input(INPUT_GET, "id_user");

$user= $UserRepository->findById($id_user);

$nome = $user->getName();
$email = $user->getEmail();
$birthdate = $user->getBirthdate();

$array = [
    'error' => '',
    'id' => $id_user,
    'nome' => $nome,
    'email' => $email,
    'birthdate' => date("d/m/Y", strtotime($birthdate)),
];

header("Content-type: application/json");
echo json_encode($array);
exit;

?>
