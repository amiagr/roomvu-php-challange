<?php

use App\Repository\TransactionRepository;
use App\Repository\UserRepository;
use App\Service\ReportService;
use PHPUnit\Framework\TestCase;

class IntegrationTest extends TestCase
{
//    protected UserRepository $userRepository;
//    protected TransactionRepository $transactionRepository;
//    protected ReportService $reportService;
//
//    protected function setUp(): void
//    {
//        $config = require 'config.php';
//
//        $host = $config['db']['host'];
//        $dbname = $config['db']['db_name'];
//        $username = $config['db']['username'];
//        $password = $config['db']['password'];
//
//        $this->pdo = new PDO(dsn: "mysql:host=$host;dbname=$dbname", username: $username, password: $password);
//
//        $this->userRepository = new UserRepository($pdo);
//        $this->transactionRepository = new TransactionRepository($pdo);
//        if (!empty($this->userRepository)) {
//            $this->reportService = new ReportService($this->userRepository, $this->transactionRepository);
//        }
//    }
//
//    public function testGenerateUserWiseTransactionReport()
//    {
//        // Add users and transactions to the repositories
//
//        // Generate the report
//        $report = $this->reportService->generateUserWiseTransactionReport(1);
//
//        // Perform assertions based on the expected results
//        $this->assertNotEmpty($report);
//        // Add more assertions as needed
//    }
}