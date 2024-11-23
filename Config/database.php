<?php
    require_once "Config.php";

    try{
        $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
    }
    catch(PDOException $err){
        echo "erro: " . $err;
    }

?>