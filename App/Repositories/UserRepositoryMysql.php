<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\System;
use App\Models\User;
use PDO;

class UserRepositoryMysql implements UserRepositoryInterface{
    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    public function create(User $user)
    {
        $sql = $this->pdo->prepare("INSERT INTO users
        (name, email, password, avatar, birthdate, cpf, token) VALUES (:name, :email, :password, :avatar, :birthdate, :cpf, :token)");
        $sql->bindValue(":name", $user->getName());
        $sql->bindValue(":email", $user->getEmail());
        $sql->bindValue(":password", $user->getPassword());
        $sql->bindValue(":avatar", $user->getAvatar());
        $sql->bindValue(":birthdate", $user->getBirthdate());
        $sql->bindValue(":cpf", $user->getCpf());
        $sql->bindValue(":token", $user->getToken());
        $sql->execute();

        $systemRepository = new SystemRepositoryMysql($this->pdo);
        $system = new System($this->pdo);

        $system->id_user = $this->pdo->lastInsertId();

        $systemRepository->create($system);
    }

    public function update(User $user)
    {
        $sql = $this->pdo->prepare("UPDATE users SET
            name = :name,
            email = :email,
            password = :password,
            avatar = :avatar,
            birthdate = :birthdate,
            cpf = :cpf,
            token = :token
        WHERE id = :id");
        $sql->bindValue(":name", $user->getName());
        $sql->bindValue(":email", $user->getEmail());
        $sql->bindValue(":password", $user->getPassword());
        $sql->bindValue(":avatar", $user->getAvatar());
        $sql->bindValue(":birthdate", $user->getBirthdate());
        $sql->bindValue(":cpf", $user->getCpf());
        $sql->bindValue(":token", $user->getToken());
        $sql->bindValue(":id", $user->getId());
        $sql->execute();
    }
    
    public function findAll()
    {
        $array = [];

        $sql = $this->pdo->prepare("SELECT * FROM users");
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $item){
                $user = $this->_generateUser($item);
                $array[] = $user;
            }

            return $array;
            exit;

        }

        $array["error"] = "Não há Usuários Para Mostrar";
        return $array;
        exit;
    }

    public function findById($id)
    {
        $array = [];

        $sql = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $user = $this->_generateUser($data);
            $array = $user;

            return $array;
            exit;

        }

        return false;
        exit;
    }

    public function findByName($name)
    {
        $array = [];

        $sql = $this->pdo->prepare("SELECT * FROM users WHERE name = :name");
        $sql->bindValue(":name", $name);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $user = $this->_generateUser($data);
            $array = $user;

            return $array;
            exit;

        }

        return false;
        exit;
    }

    public function findByEmail($email)
    {
        $array = [];

        $sql = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $sql->bindValue(":email", $email);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $user = $this->_generateUser($data);
            $array = $user;

            return $array;
            exit;

        }

        return false;
        exit;
    }

    public function findByCpf($cpf)
    {
        $array = [];

        $sql = $this->pdo->prepare("SELECT * FROM users WHERE cpf = :cpf");
        $sql->bindValue(":cpf", $cpf);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $user = $this->_generateUser($data);
            $array = $user;

            return $array;
            exit;

        }

        return false;
        exit;
    }

    public function findByToken($token)
    {
        $array = [];

        $sql = $this->pdo->prepare("SELECT * FROM users WHERE token = :token");
        $sql->bindValue(":token", $token);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $user = $this->_generateUser($data);
            $array = $user;

            return $array;
            exit;

        }

        return false;
        exit;
    }

    public function delete($id)
    {
        $sql = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        $sql->bindValue("id", $id);
        $sql->execute();
    }

    private function _generateUser($data)
    {
        $user = new User;
        $user->setId($data["id"]);
        $user->setName($data["name"]);
        $user->setEmail($data["email"]);
        $user->setPassword($data["password"]);
        $user->setAvatar($data["avatar"]);
        $user->setBirthdate($data["birthdate"]);
        $user->setCpf($data["cpf"]);
        $user->setToken($data["token"]);
        $user->setCreatedAt($data["created_at"]);
        $user->setUpdatedAt($data["updated_at"]);

        return $user;
    }
}

?>