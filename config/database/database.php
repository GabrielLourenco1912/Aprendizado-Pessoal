<?php

declare(strict_types=1);

namespace config\database;

use PDO;
use PDOException;
use RuntimeException;

final class database
{
    private static ?self $instance = null;
    private string $host;
    private int $port;
    private string $db;
    private string $user;
    private string $pass;

    private function __construct()
    {
        $this->host    = $_ENV['DB_HOST'];
        $this->port    = (int)$_ENV['DB_PORT'];
        $this->db      = $_ENV['DB_NAME'];
        $this->user    = $_ENV['DB_USER'];
        $this->pass    = $_ENV['DB_PASS'];
        $this->charset = $_ENV['DB_CHARSET'];
    }
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function getConnection(): PDO
    {
        $dsn = sprintf(
            'pgsql:host=%s;port=%d;dbname=%s',
            $this->host,
            $this->port,
            $this->db
        );

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            throw new RuntimeException(
                'Erro ao conectar ao banco: ' . $e->getMessage(),
                (int) $e->getCode(),
                $e
            );
        }

        return $this->pdo;
    }

    private function __clone() { throw new \Exception("Cannot unserialize singleton"); }
    public function __wakeup() { throw new \Exception("Cannot unserialize singleton"); }

    /**
     * @template T
     * @param callable(\PDO):T $fn
     * @return T Retorna o valor resultante da função passada.
     * @throws \Throwable
     */
    public function transaction(callable $fn): mixed
    {
        $pdo = $this->getConnection();

        try {
            $pdo->beginTransaction();
            $result = $fn($pdo);
            $pdo->commit();
            return $result;
        } catch (\Throwable $t) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            throw $t;
        }
    }

    public function close(): void
    {
        $this->pdo = null;
    }
}