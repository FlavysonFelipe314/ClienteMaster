<?php

use Dotenv\Dotenv;

session_start();
date_default_timezone_set("America/Sao_Paulo");

require_once "../vendor/autoload.php";

$path = __DIR__ . DIRECTORY_SEPARATOR . '..';
$dotenv = Dotenv::createUnsafeImmutable($path);
$dotenv->load();

define("SYSTEM_NAME", $_ENV["SYSTEM_NAME"]);

define("DB_HOST", $_ENV["DB_HOST"]);
define("DB_NAME", $_ENV["DB_NAME"]);
define("DB_USER", $_ENV["DB_USER"]);
define("DB_PASSWORD", $_ENV["DB_PASSWORD"]);

define("BASE", $_ENV["BASE"]);
define("BASE_DIR", $_ENV["BASE_DIR"]);

require_once "Database.php";


?>