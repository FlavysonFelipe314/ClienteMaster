<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepositoryMysql;
use PDO;

class AuthService{
    private $base;
    private $pdo; 
    private $UserRepository;

    public function __construct(PDO $driver, $base)
    {
        $this->pdo = $driver;
        $this->base = $base;
        $this->UserRepository = new UserRepositoryMysql($this->pdo);
    }

    public function checkToken()
    {
        if(!empty($_SESSION["token"])){

            $token = $_SESSION["token"];

            
            $user = $this->UserRepository->findByToken($token);
            
            if($user){
                return $user;
                exit;
            }
        }

        header("Location: ". $this->base ."/login");
        exit;
        
    }

    public function registerUser($name, $email, $password, $birthdate, $cpf)
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $token = md5(time().rand(0,9999));
        
        $User = new User($this->pdo);
        $User->setName($name);
        $User->setEmail($email);
        $User->setPassword($hash);
        $User->setToken($token);
        $User->setAvatar("default_avatar.png");
        $User->setBirthdate($birthdate);
        $User->setCpf($cpf);

        $this->UserRepository->create($User);

        $_SESSION["token"] = $token;
    }

    public function validateLogin($email, $password)
    {
        $user = $this->UserRepository->findByEmail($email);

        if($user){
            if(password_verify($password, $user->getPassword())){
                $token = md5(time().rand(0,9999));
                
                $_SESSION["token"] = $token;
                $user->setToken($token);
                $this->UserRepository->update($user);

                return true;
                exit;
            }
        }

        return false;
        exit;
    }

    public function logout(){
        session_destroy();
        unset($_SESSION["token"]);
        session_unset();
        header("Location: ". BASE);
        exit;
    }
}

?>