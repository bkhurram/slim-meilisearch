<?php

declare(strict_types=1);

namespace App;

use PDO;
use PDOException;
use RuntimeException;

final class Database
{
    public static function connect(int $maxAttempts = 15, int $sleepSeconds = 2): PDO
    {
        $host = Config::get('DB_HOST', 'db');
        $port = Config::get('DB_PORT', '3306');
        $database = Config::get('DB_DATABASE', 'slim_demo');
        $username = Config::get('DB_USERNAME', 'app');
        $password = Config::get('DB_PASSWORD', 'app_pass');

        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $database);

        $lastException = null;

        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
            try {
                $pdo = new PDO($dsn, $username, $password, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);

                return $pdo;
            } catch (PDOException $exception) {
                $lastException = $exception;
                sleep($sleepSeconds);
            }
        }

        throw new RuntimeException('Could not connect to MySQL after retries.', 0, $lastException);
    }
}
