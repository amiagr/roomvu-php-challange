<?php

namespace App;

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use PDO;

class Database
{
    protected PDO $pdo;

    public function __construct()
    {
//        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
//        $dotenv->load();

        $config = require 'config.php';

        $host = $config['db']['host'];
        $dbname = $config['db']['db_name'];
        $username = $config['db']['username'];
        $password = $config['db']['password'];

        $this->pdo = new PDO(dsn: "mysql:host=$host;dbname=$dbname", username: $username, password: $password);
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }
}
