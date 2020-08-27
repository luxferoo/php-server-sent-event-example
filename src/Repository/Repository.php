<?php

namespace App\Repository;


use App\Model\Model;

abstract class Repository
{
    protected $con;

    public function __construct($con)
    {
        $this->con = $con;
    }

    public function fetchAll(): Array
    {
        $model = $this->getModel();
        $table = $model::$table;

        $sql = "SELECT * FROM $table";

        $st = $this->con->prepare($sql);
        $st->execute();
        $result = $st->fetchAll();
        if (count($result) == 0) {
            return [];
        } else {
            return array_map(function ($row) {
                return $this->getModel()::fromArray($row);
            }, $result);
        }
    }

    abstract public function getModel();
}
