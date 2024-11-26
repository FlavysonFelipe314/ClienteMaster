<?php

namespace App\Interfaces;

use App\Models\Venda;

interface VendaRepositoryInterface{
    public function create(Venda $user);
    public function update(Venda $user);
    public function findAll($id_user);
    public function findById($id, $id_user);
    public function delete($id, $id_user);
}

?>