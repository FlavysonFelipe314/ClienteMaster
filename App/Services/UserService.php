<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepositoryMysql;
use PDO;

class UserService{
    private $pdo;
    private $UserRepository;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
        $this->UserRepository = new UserRepositoryMysql($this->pdo);
    } 

    public function emailExists($email)
    {
        if($this->UserRepository->findByEmail($email)){
            return true;
            exit;
        }

        return false;
        exit;
    }

    public function cpfExists($cpf)
    {
        if($this->UserRepository->findByCpf($cpf)){
            return true;
            exit;
        }

        return false;
        exit;
    }

    public function updateUser(User $user) {
        $this->UserRepository->update($user);
    }
    


}

?>