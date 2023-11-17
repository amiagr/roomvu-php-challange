<?php

namespace App\Repository;

use PDO;

class BaseRepository
{
    protected int $transactionDepth = 0;

    public function __construct(protected PDO $pdo)
    {
    }

    public function beginTransaction(): void
    {
        if ($this->transactionDepth == 0) {
            $this->pdo->beginTransaction();
        }

        $this->transactionDepth++;
    }

    public function commit(): void
    {
        $this->transactionDepth--;

        if ($this->transactionDepth == 0) {
            $this->pdo->commit();
        }
    }

    public function rollBack(): void
    {
        $this->transactionDepth--;

        if ($this->transactionDepth == 0) {
            $this->pdo->rollBack();
        }
    }

    public function clearTransactionState(): void
    {
        while ($this->transactionDepth > 0) {
            // Roll back any existing transactions
            $this->rollBack();
        }

        $config = require 'config.php';

        $host = $config['db']['host'];
        $dbname = $config['db']['db_name'];
        $username = $config['db']['username'];
        $password = $config['db']['password'];

        $this->pdo = new PDO(dsn: "mysql:host=$host;dbname=$dbname", username: $username, password: $password);

        // Reset the transaction depth for a new transaction
        $this->transactionDepth = 0;
    }
}