<?php

namespace Migrations;

use PDO;

abstract class BaseMigration
{
    public function __construct(protected PDO $pdo)
    {
    }

    abstract public function up();

    abstract public function down();

    public function run(): void
    {
        $this->recordMigration();
    }

    protected function recordMigration(): void
    {
        $migrationClass = static::class;

        // Check if migration has already been recorded
        $statement = $this->pdo->prepare("SELECT id FROM migrations WHERE migration = :migration");
        $statement->bindParam(':migration', $migrationClass);
        $statement->execute();

        if (!$statement->fetch()) {
            // If not recorded, execute the migration and record it
            $this->up();

            $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES (:migration)");
            $statement->bindParam(':migration', $migrationClass);
            $statement->execute();
        }
    }
}