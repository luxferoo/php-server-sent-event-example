<?php

namespace App\Repository;

class Factory
{
    private $con;

    public function __construct(\PDO $con)
    {
        $this->con = $con;
    }

    public function get(String $class) : Repository
    {
        return new $class($this->con);
    }
}
