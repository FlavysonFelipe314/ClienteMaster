<?php

namespace App\Repositories;

use App\Interfaces\VendaRepositoryInterface;
use App\Models\Venda;
use PDO;

class VendaRepositoryMysql implements VendaRepositoryInterface
{
    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    public function create(Venda $venda)
    {
        $sql = $this->pdo->prepare("
            INSERT INTO vendas (id_user, id_cliente, id_cupom, total, service) 
            VALUES (:id_user, :id_cliente, :id_cupom,  :total, :service)
        ");

        $sql->bindValue(":id_user", $venda->getIdUser());
        $sql->bindValue(":id_cliente", $venda->getIdCliente());
        $sql->bindValue(":id_cupom", $venda->getIdCupom());
        $sql->bindValue(":total", $venda->getTotal());
        $sql->bindValue(":service", $venda->getService());

        $sql->execute();
    }

    public function update(Venda $venda)
    {
        $sql = $this->pdo->prepare("
            UPDATE vendas SET 
                id_user = :id_user,
                id_cliente = :id_cliente,
                id_cupom = :id_cupom,
                total = :total,
                service = :service
            WHERE id = :id AND id_user = :id_user
        ");

        $sql->bindValue(":id_user", $venda->getIdUser());
        $sql->bindValue(":id_cliente", $venda->getIdCliente());
        $sql->bindValue(":id_cupom", $venda->getIdCupom());
        $sql->bindValue(":total", $venda->getTotal());
        $sql->bindValue(":service", $venda->getService());
        $sql->bindValue(":id", $venda->getId());

        $sql->execute();
    }

    public function findAll($id_user)
    {
        $array = [];

        $sql = $this->pdo->prepare("SELECT vendas.*, clientes.name AS cliente
        FROM vendas 
        INNER JOIN clientes ON clientes.id = vendas.id_cliente
        WHERE vendas.id_user = :id_user
        ORDER BY id DESC");
        $sql->bindValue(":id_user", $id_user);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $item) {
                $venda = $this->_generateVenda($item);
                $array[] = $venda;
            }

            return $array;
        }

        return false;
    }

    public function findById($id, $id_user)
    {
        $sql = $this->pdo->prepare("SELECT * FROM vendas WHERE id = :id AND id_user = :id_user ORDER BY id DESC");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":id_user", $id_user);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $data = $sql->fetch(PDO::FETCH_ASSOC);
            return $this->_generateVenda($data);
        }

        return false;
    }

    public function delete($id, $id_user)
    {
        $sql = $this->pdo->prepare("DELETE FROM vendas WHERE id = :id AND id_user = :id_user");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":id_user", $id_user);
        $sql->execute();
    }

    private function _generateVenda($data)
    {
        $venda = new Venda();
        $venda->setId($data["id"]);
        $venda->setIdUser($data["id_user"]);
        $venda->setIdCliente($data["id_cliente"]);
        $venda->setIdCupom($data["id_cupom"]);
        $venda->setTotal($data["total"]);
        $venda->setService($data["service"]);
        $venda->setCliente($data["cliente"]);


        return $venda;
    }
}

?>
