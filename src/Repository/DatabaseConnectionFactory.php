<?php

declare(strict_types=1);

namespace App\Repository;

use PDO;
use PDOException;
use RuntimeException;

final readonly class DatabaseConnectionFactory
{
    /** @param array<string, mixed> $dbConfig */
    public function __construct(private array $dbConfig)
    {
    }

    public function create(int $maxAttempts = 15, int $sleepSeconds = 2): PDO
    {
        $host = (string) ($this->dbConfig['host'] ?? 'db');
        $port = (string) ($this->dbConfig['port'] ?? '3306');
        $database = (string) ($this->dbConfig['database'] ?? 'slim_demo');
        $username = (string) ($this->dbConfig['username'] ?? 'app');
        $password = (string) ($this->dbConfig['password'] ?? 'app_pass');

        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $database);
        $lastException = null;

        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
            try {
                return new PDO($dsn, $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
            } catch (PDOException $exception) {
                $lastException = $exception;
                sleep($sleepSeconds);
            }
        }

        throw new RuntimeException('Could not connect to MySQL after retries.', 0, $lastException);
    }
}
