<?php

namespace App\DAO;

abstract class Conection
{
    /**
     * @var \PDO
     */
    protected $pdo;

    public function __construct()
    {
        $host = $_ENV['STOCKS_MYSQL_HOST'];
        $port = $_ENV['STOCKS_MYSQL_PORT'];
        $user = $_ENV['STOCKS_MYSQL_USER'];
        $pass = $_ENV['STOCKS_MYSQL_PASSWORD'];
        $dbname = $_ENV['STOCKS_MYSQL_DBNAME'];

        $dsn = "mysql:host={$host};dbname={$dbname};port={$port}";

        $this->pdo = new \PDO($dsn, $user, $pass);
        $this->pdo->setAttribute(
            \PDO::ATTR_ERRMODE,
            \PDO::ERRMODE_EXCEPTION
        );
    }
}
