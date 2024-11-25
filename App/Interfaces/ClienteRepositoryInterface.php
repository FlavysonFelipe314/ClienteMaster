<?php

namespace App\Interfaces;

use App\Models\Cliente;

interface ClienteRepositoryInterface{
    public function create(Cliente $user);
    public function update(Cliente $user);
    public function findAll($id_user);
    public function findById($id, $id_user);
    public function findByName($name, $id_user);
    public function findByEmail($email, $id_user);
    public function delete($id, $id_user);
}

?>