<?php

namespace App\Services;

use App\Models\Cliente;
use App\Repositories\ClienteRepositoryMysql;
use PDO;

class ClienteService{
    private $pdo;
    private $ClienteRepository;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
        $this->ClienteRepository = new ClienteRepositoryMysql($this->pdo);
    } 

    public function emailExists($email, $id_user)
    {
        if($this->ClienteRepository->findByEmail($email, $id_user)){
            return true;
            exit;
        }

        return false;
        exit;
    }
    

    public function resgisterCliente($name, $email, $avatar, $birthdate, $id_user)
    { 
        $Cliente = new Cliente;
        $Cliente->setName($name);
        $Cliente->setEmail($email);
        $Cliente->setAvatar($avatar);
        $Cliente->setBirthdate($birthdate);
        $Cliente->setIdUser($id_user);

        $this->ClienteRepository->create($Cliente);
    }

    public function countTotalClientes($id_user)
    {
        $data = $this->ClienteRepository->findAll($id_user);
        $total = (!empty($data)) ? count($data) : 0;
        return $total;
    }

    public function countTotalBirthdate($id_user)
    {
        $data = $this->ClienteRepository->findBirthdateMonth($id_user);
        $total = (!empty($data)) ? count($data) : 0;
        return $total;
    }

    public function search($query, $id_user){
        $data = $this->ClienteRepository->search($query, $id_user);
        return $data;
    }

    public function getAllClientes($id_user){
        $data = $this->ClienteRepository->findAll($id_user);
        return $data;
    }

}

?>