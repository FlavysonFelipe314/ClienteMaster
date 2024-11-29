<?php

use App\Services\AuthService;
use App\Services\UserService;

require_once "../Config/config.php";

$AuthService = new AuthService($pdo, BASE); 
$UserService = new UserService($pdo);

$userInfo = $AuthService->checkToken(); // Garantir que o usuário está autenticado
$id = $userInfo->getId();

$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$birthdate = filter_input(INPUT_POST, "birthdate");
$password = filter_input(INPUT_POST, "password");
$confirmPassword = filter_input(INPUT_POST, "confirmPassword");
$avatar = $_FILES['avatar'] ?? null;

if ($name && $email && $birthdate) {
    
    $acceptPerfil = ["image/png", "image/jpeg", "image/jpg"];

    $birthdate = explode("/", $birthdate);
    if (count($birthdate) !== 3) {
        $_SESSION["flash"] = "Data de Nascimento Inválida";
        header("Location: " . BASE . "/perfil");
        exit;
    }

    $birthdate = $birthdate[2] . "-" . $birthdate[1] . "-" . $birthdate[0];
    if (strtotime($birthdate) === false) {
        $_SESSION["flash"] = "Data de Nascimento Inválida";
        header("Location: " . BASE . "/perfil");
        exit;
    }

    if ($password && $confirmPassword) {
        if ($password !== $confirmPassword) {
            $_SESSION["flash"] = "As senhas não batem";
            header("Location: " . BASE . "/perfil");
            exit;
        }
    }

    if($avatar["size"] != 0)
        {
            if(in_array($avatar["type"], $acceptPerfil)){

                $perfilWidth = 500;
                $perfilHeight = 500;
                
                list($widthOrig, $heightOrig) = getimagesize($avatar["tmp_name"]);
                $ratio = $widthOrig / $heightOrig;
                
                $newWidth = $perfilWidth;
                $newHeight = $newWidth / $ratio;
                
                if ($newHeight < $perfilHeight) {
                    $newHeight = $perfilHeight;
                    $newWidth = $newHeight * $ratio;
                }
                
                $x = ($perfilWidth - $newWidth) / 2;
                $y = ($perfilHeight - $newHeight) / 2;
                
                $finalImage = imagecreatetruecolor($perfilWidth, $perfilHeight);
                
                switch ($avatar["type"]) {
                    case "image/jpeg":
                    case "image/jpg":
                        $image = imagecreatefromjpeg($avatar["tmp_name"]);
                        break;
                    case "image/png":
                        $image = imagecreatefrompng($avatar["tmp_name"]);
                        break;
                }
                
                imagecopyresampled(
                    $finalImage, $image,
                    $x, $y, 0, 0,
                    $newWidth, $newHeight, $widthOrig, $heightOrig
                );
        
                $perfilName = md5(time().rand(0, 9999).'.jpg');
                $userInfo->setAvatar($perfilName);
                
                imagejpeg($finalImage, "../uploads/avatar/".$perfilName, 100); 
            }else{
                $_SESSION["flash"] = "O arquivo da não corresponde os formatos exigidos";
                header("Location: ".$base."/editar_cliente");
                exit;
            }
        }

    
    $userInfo->setName($name);
    $userInfo->setEmail($email);
    $userInfo->setBirthdate($birthdate);


    if ($password) {
        $userInfo->setPassword(password_hash($password, PASSWORD_DEFAULT));
    }

    $UserService->updateUser($userInfo);

    $_SESSION["flash"] = "Perfil atualizado com sucesso!";
    header("Location: " . BASE . "/perfil");
    exit;
}

$_SESSION["flash"] = "Preencha todos os campos obrigatórios.";
header("Location: " . BASE . "/perfil");
exit;
