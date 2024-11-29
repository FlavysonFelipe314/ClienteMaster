<?php

use App\Repositories\SystemRepositoryMysql;
use App\Models\System;
use App\Services\AuthService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE);
$userInfo = $AuthService->checkToken();

$systemRepository = new SystemRepositoryMysql($pdo);

// Dados do formulário
$business_name = filter_input(INPUT_POST, 'business_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$primary_color = filter_input(INPUT_POST, 'primary_color', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$secondary_color = filter_input(INPUT_POST, 'secondary_color', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$background_color = filter_input(INPUT_POST, 'background_color', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

$logo = $_FILES['logo'] ?? null;

if ($business_name && $primary_color && $secondary_color && $background_color && $id) {
    // Processar o upload da logo
    $logoName = null;
    if ($logo && $logo['size'] > 0) {
        $acceptedFormats = ['image/png', 'image/jpeg', 'image/jpg'];
        if (in_array($logo['type'], $acceptedFormats)) {
            $logoName = md5(time() . rand(0, 9999)) . '.jpg';

            // Caminho para salvar a imagem
            move_uploaded_file($logo['tmp_name'], "../uploads/logos/" . $logoName);
        } else {
            $_SESSION['flash'] = 'Formato de imagem inválido.';
            header("Location: " . BASE . "/configuracoes");
            exit;
        }
    }

    // Recuperar o sistema e atualizar os dados
    $system = $systemRepository->findById($userInfo->getId());
    if ($system) {
        $system->business_name = $business_name;
        $system->primary_color = $primary_color;
        $system->secondary_color = $secondary_color;
        $system->background_color = $background_color;

        // Atualizar o logo apenas se foi enviado um novo
        if ($logoName) {
            $system->logo = $logoName;
        }

        $systemRepository->update($system);

        $_SESSION['flash'] = 'Sistema atualizado com sucesso!';
        header("Location: " . BASE . "/configuracoes");
        exit;
    } else {
        $_SESSION['flash'] = 'Sistema não encontrado.';
        header("Location: " . BASE . "/configuracoes");
        exit;
    }
}

$_SESSION['flash'] = 'Preencha todos os campos obrigatórios.';
header("Location: " . BASE . "/configuracoes");
exit;
