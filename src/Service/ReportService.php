<?php

namespace App\Service;

use App\Repository\TransactionRepository;

class ReportService
{
    protected TransactionRepository $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    public function getUserReport(int $userId, string $date): float
    {
        // Implementation to calculate and return user report
        return 0.0;
    }

    public function getOverallReport(string $date): float
    {
        // Implementation to calculate and return overall report
        return 0.0;
    }
}
