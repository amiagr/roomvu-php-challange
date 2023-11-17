<?php

namespace App\Repository;

use App\Entity\User;
use Exception;
use PDO;

class UserRepository extends BaseRepository
{
    public function createUser(User $user): void
    {
        try {
            $this->beginTransaction();

            $statement = $this->pdo->prepare("INSERT INTO users (name, credit) VALUES (:name, :credit)");
            $statement->bindParam(':name', $user->name);
            $statement->bindParam(':credit', $user->credit);
            $statement->execute();

            $this->commit();
        } catch (Exception $e) {
            $this->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }

    public function getById(int $id): ?User
    {
        $statement = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();

        $userData = $statement->fetch(PDO::FETCH_ASSOC);

        if ($userData) {
            return new User(id: $userData['id'], name: $userData['name'], credit: $userData['credit']);
        }

        return null;
    }

    public function getAll(): array
    {
        $statement = $this->pdo->query("SELECT * FROM users");
        $userList = [];

        while ($userData = $statement->fetch(PDO::FETCH_ASSOC)) {
            $userList[] = new User($userData['id'], $userData['name'], $userData['credit']);
        }

        return $userList;
    }

    public function update(User $user): void
    {
        $statement = $this->pdo->prepare("UPDATE users SET name = :name, credit = :credit WHERE id = :id");
        $statement->bindParam(':name', $user->name);
        $statement->bindParam(':credit', $user->credit);
        $statement->bindParam(':id', $user->id);
        $statement->execute();
    }

    public function delete(int $id): void
    {
        $statement = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();
    }

    public function userReportPerDay(int $userId)
    {
        $cacheDir = __DIR__ . '/../../cache';
        $cacheUser = $userId === 0 ? 'all' : $userId;
        $cacheFile = $cacheDir . "/user_report_cache_{$cacheUser}.json";

        // Check if the cache directory exists, create it if not
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0755, true);
        }

        // Check if the cache file exists and is not stale
        if (file_exists($cacheFile) && filemtime($cacheFile) > strtotime('-1 day')) {
            // If cache is valid, read and output the cached data
            $cachedData = json_decode(file_get_contents($cacheFile), true);

            if (!empty($cachedData)) {
                echo "Cached User-wise Transaction Report:\n";
                foreach ($cachedData as $row) {
                    echo "User ID (from file): {$row['user_id']}, Date: {$row['transaction_date']}, Total Amount: {$row['total_amount']}\n";
                }

                return;
            }
        }

        try {
            $this->beginTransaction();

            if (!$userId) {
                $statement = $this->pdo->prepare("
                    SELECT user_id, DATE(created_at) as transaction_date, SUM(amount) as total_amount
                    FROM transactions
                    GROUP BY user_id, DATE(created_at)
                ");
            } else {
                $statement = $this->pdo->prepare("
                    SELECT user_id, DATE(created_at) as transaction_date, SUM(amount) as total_amount
                    FROM transactions
                    WHERE user_id = :user_id
                    GROUP BY DATE(created_at)
                ");
                $statement->bindParam(':user_id', $userId);
            }

            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($result)) {
                echo "User-wise Transaction Report:\n";
                foreach ($result as $row) {
                    echo "User ID: {$row['user_id']}, Date: {$row['transaction_date']}, Total Amount: {$row['total_amount']}\n";
                }
                file_put_contents($cacheFile, json_encode($result));
            } else {
                echo "No transactions found\n";
            }

            $this->commit();
        } catch (Exception $e) {
            $this->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }
}
