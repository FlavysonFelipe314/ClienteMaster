<?php

namespace App\Repositories;

use App\Interfaces\VisitaRepositoryInterface;
use App\Models\Visita;
use PDO;

class VisitaRepositoryMysql implements VisitaRepositoryInterface
{
    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    public function create(Visita $visita)
    {
        $sql = $this->pdo->prepare("
            INSERT INTO visitas (id_user, id_cliente, data_visita, description) 
            VALUES (:id_user, :id_cliente, :data_visita, :description)
        ");

        $sql->bindValue(":id_user", $visita->getIdUser());
        $sql->bindValue(":id_cliente", $visita->getIdCliente());
        $sql->bindValue(":data_visita", $visita->getDataVisita());
        $sql->bindValue(":description", $visita->getDescription());

        $sql->execute();
    }

    public function update(Visita $visita)
    {
        $sql = $this->pdo->prepare("
            UPDATE visitas SET 
                id_user = :id_user,
                id_cliente = :id_cliente,
                data_visita = :data_visita,
                description = :description
            WHERE id = :id AND id_user = :id_user
        ");

        $sql->bindValue(":id_user", $visita->getIdUser());
        $sql->bindValue(":id_cliente", $visita->getIdCliente());
        $sql->bindValue(":data_visita", $visita->getDataVisita());
        $sql->bindValue(":description", $visita->getDescription());
        $sql->bindValue(":id", $visita->getId());

        $sql->execute();
    }

    public function findAll($id_user)
    {
        $array = [];

        $sql = $this->pdo->prepare("SELECT visitas.*, clientes.name AS cliente
        FROM visitas
        INNER JOIN clientes ON clientes.id = visitas.id_cliente
        WHERE visitas.id_user = :id_user
        ORDER BY visitas.id DESC");

        $sql->bindValue(":id_user", $id_user);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $data = $sql->fetchAll(PDO::FETCH_ASSOC);

            foreach ($data as $item) {
                $visita = $this->_generateVisita($item);
                $array[] = $visita;
            }

            return $array;
        }

        return false;
    }
    
    public function findById($id, $id_user)
    {
        $sql = $this->pdo->prepare("SELECT visitas.*, clientes.name AS cliente
        FROM visitas
        INNER JOIN clientes ON clientes.id = visitas.id_cliente
        WHERE id = :id AND id_user = :id_user");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":id_user", $id_user);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $data = $sql->fetch(PDO::FETCH_ASSOC);
            return $this->_generateVisita($data);
        }

        return false;
    }

    public function delete($id, $id_user)
    {
        $sql = $this->pdo->prepare("DELETE FROM visitas WHERE id = :id AND id_user = :id_user");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":id_user", $id_user);
        $sql->execute();
    }

    private function _generateVisita($data)
    {
        $visita = new Visita();
        $visita->setId($data["id"]);
        $visita->setIdUser($data["id_user"]);
        $visita->setIdCliente($data["id_cliente"]);
        $visita->setDataVisita($data["data_visita"]);
        $visita->setDescription($data["description"]);
        $visita->setCliente($data["cliente"]);

        return $visita;
    }
}

?>
