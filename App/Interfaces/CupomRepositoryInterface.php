<?php

namespace App\Interfaces;

use App\Models\Cupom;

interface CupomRepositoryInterface{
    public function create(Cupom $user);
    public function update(Cupom $user);
    public function findAll($id_user);
    public function findById($id, $id_user);
    public function delete($id, $id_user);
}

?>