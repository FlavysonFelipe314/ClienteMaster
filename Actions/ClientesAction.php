<?php

use App\Models\Cliente;
use App\Repositories\ClienteRepositoryMysql;
use App\Services\AuthService;
use App\Services\ClienteService;

require_once "../Config/config.php";

$ClienteService = new ClienteService($pdo);
$ClienteRepository = new ClienteRepositoryMysql($pdo);

$AuthService = new AuthService($pdo, BASE);
$userInfo = $AuthService->checkToken();

// Create
if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["action"] == "create")
{
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $birthdate = filter_input(INPUT_POST, "birthdate");
    $avatar = $_FILES["avatar"];

    $acceptPerfil = ["image/png", "image/jpeg", "image/jpg"];

    if($name && $email && $birthdate)
    {

        $birthdate = explode("/", $birthdate);
        if(count($birthdate) != 3)
        {
            $_SESSION["flash"] = "Data de Nascimento Inválida";
            header("Location: ".BASE."/editar_cliente");
            exit;
        }

        $birthdate = $birthdate[2]."-".$birthdate[1]."-".$birthdate[0];
        if(strtotime($birthdate) === false)
        {
            $_SESSION["flash"] = "Data de Nascimento Inválida";
            header("Location: ".BASE."/editar_cliente");
            exit;
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
                
                imagejpeg($finalImage, "../uploads/avatar/".$perfilName, 100); 
            }else{
                $_SESSION["flash"] = "O arquivo da não corresponde os formatos exigidos";
                header("Location: ".$base."/editar_cliente");
                exit;
            }
        }

        if($ClienteService->emailExists($email, $userInfo->getId()) === false)
        {
            $avatarName = ($perfilName) ? $perfilName : "default_avatar.png";

            $ClienteService->resgisterCliente($name, $email, $avatarName, $birthdate,  $userInfo->getId());

            $_SESSION["flash"] = "cliente Cadastrado Com Sucesso";
            header("Location: ".BASE."/clientes");
            exit;
        }else{
            $_SESSION["flash"] = "O email já está em uso";
            header("Location: ".BASE."/editar_cliente");
            exit;
        }
    }

}

// Update
if($_SERVER["REQUEST_METHOD"] == "POST"  && $_POST["action"] == "update")
{
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $birthdate = filter_input(INPUT_POST, "birthdate");
    $avatar = $_FILES["avatar"];

    $acceptPerfil = ["image/png", "image/jpeg", "image/jpg"];

    if($name && $email && $birthdate)
    {

        $birthdate = explode("/", $birthdate);
        if(count($birthdate) != 3)
        {
            $_SESSION["flash"] = "Data de Nascimento Inválida";
            header("Location: ".BASE."/editar_cliente");
            exit;
        }

        $birthdate = $birthdate[2]."-".$birthdate[1]."-".$birthdate[0];
        if(strtotime($birthdate) === false)
        {
            $_SESSION["flash"] = "Data de Nascimento Inválida";
            header("Location: ".BASE."/editar_cliente");
            exit;
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

        $Cliente = $ClienteRepository->findByEmail($email, $userInfo->getId());
        if($Cliente->getEmail() != $email){
            if($ClienteService->emailExists($email, $userInfo->getId()) === false){
                $Cliente->setEmail($email);
            }
            else{
                $_SESSION["flash"] = "Email já está em uso";
                header("Location: ".BASE."/editar_cliente");
                exit;
            }
        }

        $Cliente->setName($name);
        $Cliente->setBirthdate($birthdate);
        $Cliente->setIdUser($userInfo->getId());
        $ClienteRepository->update($Cliente);

        $_SESSION["flash"] = "cliente Atualizado Com Sucesso";
        header("Location: ".BASE."/clientes");
        exit;
    }
}

// Delete
if($_SERVER["REQUEST_METHOD"] == "GET")
{
    $id = filter_input(INPUT_GET, "id");

    $ClienteRepository->delete($id, $userInfo->getId());
    $_SESSION["flash"] = "Cliente Deletado com Sucesso";
    header("Location: ".BASE."/clientes");
    exit;

}

$_SESSION["flash"] = "Preencha Todos os Campos Corretamente";
header("Location: ".BASE."/editar_cliente");
exit;

?>