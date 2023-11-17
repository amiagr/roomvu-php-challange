<?php

namespace App\Repository;

use App\Entity\Transaction;
use Exception;
use PDO;

class TransactionRepository extends BaseRepository
{
    /**
     * @throws Exception
     */
    public function createTransaction(Transaction $transaction): void
    {
        try {
            $this->beginTransaction();

            $statement = $this->pdo->prepare("INSERT INTO transactions (user_id, amount, created_at) VALUES (:user_id, :amount, :created_at)");
            $statement->bindParam(':user_id', $transaction->userId);
            $statement->bindParam(':amount', $transaction->amount);
            $statement->bindParam(':created_at', $transaction->date);
            $statement->execute();

            // Update the user's credit in the users table (replace with actual SQL)
            $updateStatement = $this->pdo->prepare("UPDATE users SET credit = credit + :amount WHERE id = :user_id");
            $updateStatement->bindParam(':user_id', $transaction->userId);
            $updateStatement->bindParam(':amount', $transaction->amount);
            $updateStatement->execute();

            $this->commit();
        } catch (Exception $e) {
            $this->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }

    public function getByUserIdAndDate(int $userId, string $date): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM transactions WHERE user_id = :user_id AND transaction_date = :transaction_date");
        $statement->bindParam(':user_id', $userId);
        $statement->bindParam(':transaction_date', $date);
        $statement->execute();

        $transactionList = [];

        while ($transactionData = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $transactionList[] = new Transaction($transactionData['user_id'], $transactionData['amount'], $transactionData['transaction_date']);
        }

        return $transactionList;
    }

    public function getAll(): array
    {
        $statement = $this->pdo->query("SELECT * FROM transactions");
        $transactionList = [];

        while ($transactionData = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $transactionList[] = new Transaction($transactionData['user_id'], $transactionData['amount'], $transactionData['transaction_date']);
        }

        return $transactionList;
    }

    public function update(Transaction $transaction): void
    {
        $statement = $this->pdo->prepare("UPDATE transactions SET amount = :amount WHERE user_id = :user_id AND transaction_date = :transaction_date");
        $statement->bindParam(':amount', $transaction->amount);
        $statement->bindParam(':user_id', $transaction->userId);
        $statement->bindParam(':transaction_date', $transaction->date);
        $statement->execute();
    }

    public function delete(int $userId, string $date): void
    {
        $statement = $this->pdo->prepare("DELETE FROM transactions WHERE user_id = :user_id AND transaction_date = :transaction_date");
        $statement->bindParam(':user_id', $userId);
        $statement->bindParam(':transaction_date', $date);
        $statement->execute();
    }
}
