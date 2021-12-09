<?php

namespace app\core;

/**
 * Class Database
 *
 * @package app\core
 */
class Database
{
    private \PDO $pdo;

    public function __construct(array $dbConfig = [])
    {
        $dbDsn = $dbConfig['dsn'] ?? '';
        $username = $dbConfig['user'] ?? '';
        $password = $dbConfig['password'] ?? '';

        $this->pdo = new \PDO($dbDsn, $username, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
}