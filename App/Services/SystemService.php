<?php

namespace App\Services;

use App\Models\System;
use App\Repositories\SystemRepositoryMysql;
use PDO;

class SystemService{
    private $pdo;
    private $SystemRepository;

    public function __construct(PDO $driver)
    {
        $this->pdo = $driver;
        $this->SystemRepository = new SystemRepositoryMysql($this->pdo);
    } 


}

?>