<?php

namespace PHPFramework;

use PDO;
use PDOException;
use PDOStatement;

class Database
{

    protected PDO $connection;

    protected PDOStatement $statement;


    public function __construct()
    {
        $dsn = "mysql:host=" . DB_SETTINGS['host'] . ";dbname=" . DB_SETTINGS['database'] . ";charset=" . DB_SETTINGS['charset'];

        try {
            $this->connection = new PDO($dsn, DB_SETTINGS['username'], DB_SETTINGS['password'], DB_SETTINGS['options']);
        } catch (PDOException $exception) {
            error_log("[" . date('Y-m-d H:i:s') . "] DB Error: {$exception->getMessage()}" . PHP_EOL, 3, ERROR_LOGS);
            abort('DB error connection', 500);
        }

        return $this;
    }

    public function query(string $query, array $params = []): static
    {
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute($params);

        return $this;
    }

    public function get(): array|false
    {
        return $this->statement->fetchAll();
    }

    public function getAssoc($key = 'id'): array
    {
        $data = [];

        while ($row = $this->statement->fetch()) {
            $data[$row[$key]] = $row;
        }

        return $data;
    }

    public function getOne()
    {
        return $this->statement->fetch();
    }

    public function getColumn()
    {
        return $this->statement->fetchColumn();
    }

    public function getInsertId(): false|string
    {
        return $this->connection->lastInsertId();
    }

    public function rowCount(): int
    {
        return $this->statement->rowCount();
    }

    public function beginTransaction(): bool
    {
        return $this->connection->beginTransaction();
    }

    public function commit(): bool
    {
        return $this->connection->commit();
    }

    public function rollBack(): bool
    {
        return $this->connection->rollBack();
    }

    public function findAll(string $table): array|false
    {
        $this->query("select * from {$table}");

        return $this->statement->fetchAll();
    }

    public function findOne(string $table, mixed $whereValue, string $whereKey = 'id')
    {
        $this->query("select * from {$table} where {$whereKey} = ? limit 1", [$whereValue]);

        return $this->statement->fetch();
    }

    public function findOrFail(string $table, mixed $whereValue, string $whereKey = 'id')
    {
        $queryResult = $this->findOne($table, $whereValue, $whereKey);

        if (!$queryResult) {
            abort();
        }

        return $queryResult;
    }

    /**
     * @throws \Throwable
     */
    public function transaction(callable $callback): mixed
    {
        $this->beginTransaction();

        try {
            $result = $callback($this);
            $this->commit();

            return $result;
        } catch (\Throwable $e) {
            $this->rollBack();

            throw $e;
        }
    }

}
