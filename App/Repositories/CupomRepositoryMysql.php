<?php

namespace App\Repositories;

use App\Interfaces\CupomRepositoryInterface;
use App\Models\Cupom;
use PDO;

class CupomRepositoryMysql implements CupomRepositoryInterface{
    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    public function create(Cupom $cupom)
    {
        $sql = $this->pdo->prepare("INSERT INTO cupons
        (id_user, id_client, name, total_discount, type_discount) VALUES
        (:id_user, :id_client, :name, :total_discount, :type_discount)");
    
        $sql->bindValue(":id_user", $cupom->getIdUser());
        $sql->bindValue(":id_client", $cupom->getIdClient());
        $sql->bindValue(":name", $cupom->getName());
        $sql->bindValue(":total_discount", $cupom->getTotalDiscount());
        $sql->bindValue(":type_discount", $cupom->getTypeDiscount());
    
        $sql->execute();
    }
    
    public function update(Cupom $cupom)
    {
        $sql = $this->pdo->prepare("UPDATE cupons SET
            id_client = :id_client,
            name = :name,
            total_discount = :total_discount,
            type_discount = :type_discount
        WHERE id = :id AND id_user = :id_user");
        
        $sql->bindValue(":id_client", $cupom->getIdClient());
        $sql->bindValue(":name", $cupom->getName());
        $sql->bindValue(":total_discount", $cupom->getTotalDiscount());
        $sql->bindValue(":type_discount", $cupom->getTypeDiscount());
        $sql->bindValue(":id", $cupom->getId());
        $sql->bindValue(":id_user", $cupom->getIdUser());
        $sql->execute();
    
    }

    public function findAll($id_user)
    {
        $array = [];

        $sql = $this->pdo->prepare("SELECT * FROM cupons WHERE id_user = :id_user ORDER BY id DESC");
        $sql->bindValue(":id_user", $id_user);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $item){
                $cupom = $this->_generateCupom($item);
                $array[] = $cupom;
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

        $sql = $this->pdo->prepare("SELECT * FROM cupons WHERE id = :id AND id_user = :id_user ORDER BY id DESC");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":id_user", $id_user);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $item){
                $cupom = $this->_generateCupom($item);
                $array = $cupom;
            }

            return $array;
            exit;

        }
        return false;
        exit;
    }

    public function delete($id, $id_user)
    {
        $sql = $this->pdo->prepare("DELETE FROM cupons WHERE id = :id AND id_user = :id_user");
        $sql->bindValue("id", $id);
        $sql->bindValue(":id_user", $id_user);
        $sql->execute();
    }

    private function _generateCupom($data)
    {
        $cupom = new Cupom;
        $cupom->setId($data["id"]);
        $cupom->setIdUser($data["id_user"]);
        $cupom->setIdClient($data["id_client"]);
        $cupom->setName($data["name"]);
        $cupom->setTotalDiscount($data["total_discount"]);
        $cupom->setTypeDiscount($data["type_discount"]);
    
        return $cupom;
    }
    
}

?>