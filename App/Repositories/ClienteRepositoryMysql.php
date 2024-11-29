<?php

namespace App\Repositories;

use App\Interfaces\ClienteRepositoryInterface;
use App\Models\Cliente;
use PDO;

class ClienteRepositoryMysql implements ClienteRepositoryInterface{
    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    public function create(Cliente $cliente)
    {
        $sql = $this->pdo->prepare("INSERT INTO clientes
        (id_user, name, email, avatar, birthdate) VALUES (:id_user, :name, :email, :avatar, :birthdate)");
        $sql->bindValue(":id_user", $cliente->getIdUser());
        $sql->bindValue(":name", $cliente->getName());
        $sql->bindValue(":email", $cliente->getEmail());
        $sql->bindValue(":avatar", $cliente->getAvatar());
        $sql->bindValue(":birthdate", $cliente->getBirthdate());
        $sql->execute();
    }

    public function update(Cliente $cliente)
    {
        $sql = $this->pdo->prepare("UPDATE clientes SET
            name = :name,
            email = :email,
            avatar = :avatar,
            birthdate = :birthdate,
            ranking = :ranking
        WHERE id = :id AND id_user = :id_user");
        $sql->bindValue(":name", $cliente->getName());
        $sql->bindValue(":email", $cliente->getEmail());
        $sql->bindValue(":avatar", $cliente->getAvatar());
        $sql->bindValue(":birthdate", $cliente->getBirthdate());
        $sql->bindValue(":ranking", $cliente->getRanking());
        $sql->bindValue(":id", $cliente->getId());
        $sql->bindValue(":id_user", $cliente->getIdUser());
        $sql->execute();
    }
    
    public function findAll($id_user)
    {
        $array = [];

        $sql = $this->pdo->prepare("SELECT clientes.*,
        SUM(DISTINCT vendas.total) AS total
        FROM clientes 
        LEFT JOIN vendas ON vendas.id_cliente = clientes.id
        WHERE clientes.id_user = :id_user
        GROUP BY clientes.id
        ORDER BY clientes.created_at DESC;
        ");
        $sql->bindValue(":id_user", $id_user);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $item){
                $cliente = $this->_generateUser($item);
                $array[] = $cliente;
            }

            return $array;
            exit;

        }
        return false;
        exit;
    }

    public function findTop10($id_user)
    {
        $array = [];

        $sql = $this->pdo->prepare("SELECT clientes.*,
        SUM(DISTINCT vendas.total) AS total
        FROM clientes 
        LEFT JOIN vendas ON vendas.id_cliente = clientes.id
        WHERE clientes.id_user = :id_user
        GROUP BY clientes.id
        ORDER BY clientes.ranking DESC LIMIT 10;
        ");
        $sql->bindValue(":id_user", $id_user);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $item){
                $cliente = $this->_generateUser($item);
                $array[] = $cliente;
            }

            return $array;
            exit;

        }
        return false;
        exit;
    }

    public function findById($id, $id_user)
    {
        $array = [];

        $sql = $this->pdo->prepare("SELECT * FROM clientes WHERE id = :id AND id_user = :id_user");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":id_user", $id_user);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $cliente = $this->_generateUser($data);
            $array = $cliente;

            return $array;
            exit;

        }

        return false;
        exit;
    }

    public function findByName($name, $id_user)
    {
        $array = [];

        $sql = $this->pdo->prepare("SELECT * FROM clientes WHERE name = :name AND id_user = :id_user");
        $sql->bindValue(":name", $name);
        $sql->bindValue(":id_user", $id_user);

        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $cliente = $this->_generateUser($data);
            $array = $cliente;

            return $array;
            exit;

        }

        return false;
        exit;
    }

    public function findByEmail($email, $id_user)
    {
        $array = [];

        $sql = $this->pdo->prepare("SELECT * FROM clientes WHERE email = :email AND id_user = :id_user");
        $sql->bindValue(":email", $email);
        $sql->bindValue(":id_user", $id_user);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $cliente = $this->_generateUser($data);
            $array = $cliente;

            return $array;
            exit;

        }

        return false;
        exit;
    }

    public function findBirthdateMonth($id_user)
    {
        $array = [];

        $sql = $this->pdo->prepare("SELECT * FROM clientes
        WHERE MONTH(birthdate) = MONTH(CURDATE()) AND
        id_user = :id_user");
        $sql->bindValue(":id_user", $id_user);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $item){
                $cliente = $this->_generateUser($item);
                $array[] = $cliente;
            }

            return $array;
            exit;

        }

        return false;
        exit;
    }


    public function delete($id, $id_user)
    {
        $sql = $this->pdo->prepare("DELETE FROM clientes WHERE id = :id AND id_user = :id_user");
        $sql->bindValue("id", $id);
        $sql->bindValue(":id_user", $id_user);
        $sql->execute();
    }

    public function search($query, $id_user)
    {
        $array = [];

        $sql = $this->pdo->prepare("SELECT clientes.*,
        SUM(DISTINCT vendas.total) AS total
        FROM clientes
        LEFT JOIN vendas ON vendas.id_cliente = clientes.id
        WHERE clientes.id_user = :id_user AND
        name LIKE :query
        GROUP BY clientes.id");

        $sql->bindValue(":id_user", $id_user);
        $sql->bindValue(":query", "%".$query."%");
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $item){
                $cliente = $this->_generateUser($item);
                $array[] = $cliente;
            }



            return $array;
            
            exit;

        }

        return false;
        exit;
    }

    private function _generateUser($data)
    {
        $cliente = new Cliente;
        $cliente->setId($data["id"]);
        $cliente->setIdUser($data["id_user"]);
        $cliente->setName($data["name"]);
        $cliente->setEmail($data["email"]);
        $cliente->setAvatar($data["avatar"]);
        $cliente->setRanking($data["ranking"]);
        $cliente->setBirthdate($data["birthdate"]);
        $cliente->setCreatedAt($data["created_at"]);
        $cliente->setUpdatedAt($data["updated_at"]);
        $cliente->total = isset($data["total"]) ? $data["total"] : 0 ;
        $cliente->visitas = isset($data["visitas"]) ? $data["visitas"] : 0;

        return $cliente;
    }
}

?>