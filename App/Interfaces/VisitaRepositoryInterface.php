<?php

namespace App\Interfaces;

use App\Models\Visita;

interface VisitaRepositoryInterface{
    public function create(Visita $user);
    public function update(Visita $user);
    public function findAll($id_user);
    public function findById($id, $id_user);
    public function delete($id, $id_user);
}

?>