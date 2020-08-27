<?php

namespace App\Service\Db;

class Connection
{
    private $con;

    public function init($dsn, $username, $password)
    {
        if (isset($this->con)) {
            throw new DatabaseConnectionException("Database connection already initialized");
        }
        $this->con = new \PDO($dsn, $username, $password);
        return $this;
    }

    public function getConnection()
    {
        if (!isset($this->con)) {
            throw new DatabaseConnectionException("Database connection not initialised");
        }
        return $this->con;
    }
}
