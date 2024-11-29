<?php

namespace App\Interfaces;

use App\Models\System;

interface SystemRepositoryInterface{
    public function create(System $system);
    public function update(System $system);
    public function findById($id_user);
}

?>