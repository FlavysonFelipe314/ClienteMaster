<?php

namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface{
    public function create(User $user);
    public function update(User $user);
    public function findAll();
    public function findById($id);
    public function findByName($name);
    public function findByEmail($email);
    public function findByCpf($cpf);
    public function findByToken($token);
    public function delete($id);
}

?>