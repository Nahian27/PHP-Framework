<?php

namespace phpTest\src\App\Classes;

use PDO;
use PDOException;

class DB
{
    private static ?self $instance = null;
    private ?PDO $PDO = null;

    private function __construct()
    {
        try {
            $this->PDO = new PDO(
                sprintf(
                    "pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s;sslmode=require;options=endpoint=%s",
                    $_ENV['DB_HOST'],
                    $_ENV['DB_PORT'],
                    $_ENV['DB_NAME'],
                    $_ENV['DB_USER'],
                    $_ENV['DB_PASS'],
                    $_ENV['DB_ENDPOINT']
                )
            );
        } catch (PDOException $e) {
            echo 'Database connection error: ' . $e->getMessage();
        }
    }

    public static function getInstance(): DB
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function query(string $sql, mixed ...$params): array
    {
        $stmt = $this->PDO->prepare($sql);
        try {
            $stmt->execute($params);
        } catch (PDOException $e) {
            echo 'Database Query Error: ' . $e->getMessage();
        }
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}