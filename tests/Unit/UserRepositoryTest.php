<?php

namespace Test\Unit;

use App\Database;
use App\Entity\User;
use App\Repository\UserRepository;
//use ConsoleCommand;
use PDO;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    protected UserRepository $userRepository;
    protected PDO $pdo;

    protected function setUp(): void
    {
        $config = require 'config.php';

        $host = $config['db']['host'];
        $dbname = $config['db']['db_name'];
        $username = $config['db']['username'];
        $password = $config['db']['password'];

        $this->pdo = new PDO(dsn: "mysql:host=$host;dbname=$dbname", username: $username, password: $password);

        $this->userRepository = new UserRepository($this->pdo);

//        $consoleCommand = new ConsoleCommand(new Database());
//
//        $consoleCommand->migrate();
        die();
    }

    public function testAddUser()
    {
        $user = new User(id: 1, name: 'AmirHossein', credit: 0);

        $this->userRepository->createUser($user);

        $this->assertSame($user, $this->userRepository->getById($user->id));
    }

    public function testGetNonExistentUserById()
    {
        $result = $this->userRepository->getById(999);

        $this->assertNull($result);
    }

    public function testDeleteUserById()
    {
        // Test logic (negative case)
    }

    public function testDeleteNonExistentUserById()
    {
        // Test logic (negative case)
    }

    public function testUpdateUserById()
    {
        // Test logic (negative case)
    }

    public function testUpdateNonExistentUserById()
    {
        // Test logic (negative case)
    }

}