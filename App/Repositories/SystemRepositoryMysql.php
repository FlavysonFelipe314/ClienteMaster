<?php

namespace App\Repositories;

use App\Interfaces\SystemRepositoryInterface;
use App\Models\System;
use PDO;

class SystemRepositoryMysql implements SystemRepositoryInterface{
    private $pdo;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
    }

    public function create(System $system)
    {
        $sql = $this->pdo->prepare("INSERT INTO systems (id_user) VALUES (:id_user)");
        $sql->bindValue(":id_user", $system->id_user);
        $sql->execute();
    }
    
    public function update(System $system) {
        $sql = $this->pdo->prepare("UPDATE systems 
            SET business_name = :business_name, 
                logo = :logo, 
                primary_color = :primary_color, 
                secondary_color = :secondary_color, 
                background_color = :background_color 
            WHERE id = :id
        ");
    
        $sql->bindValue(':business_name', $system->business_name);
        $sql->bindValue(':logo', $system->logo);
        $sql->bindValue(':primary_color', $system->primary_color);
        $sql->bindValue(':secondary_color', $system->secondary_color);
        $sql->bindValue(':background_color', $system->background_color);
        $sql->bindValue(':id', $system->id);
    
        $sql->execute();
    }

    
    public function findById($id_user)
    {
        $sql = $this->pdo->prepare("SELECT * FROM systems WHERE id_user = :id_user");
        $sql->bindValue(":id_user", $id_user);
        $sql->execute();

        if($sql->rowCount() > 0){
            $data = $sql->fetch(PDO::FETCH_ASSOC);

            $system = new System;

            $system->id = $data["id"];
            $system->id_user = $data["id_user"];
            $system->primary_color = $data["primary_color"];
            $system->secondary_color = $data["secondary_color"];
            $system->background_color = $data["background_color"];
            $system->logo = $data["logo"];
            $system->business_name = $data["business_name"];


            return $system;

        }

        return false;
        exit;
    }

}

?>