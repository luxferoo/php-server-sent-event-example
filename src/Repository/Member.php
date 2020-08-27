<?php

namespace App\Repository;

class Member extends Repository
{
    public function getModel()
    {
        return \App\Model\Member::class;
    }

    public function fetchByUsername(String $username): ?\App\Model\Member
    {
        $table = $this->getModel()::$table;

        $sql = "SELECT *
                FROM $table
                WHERE username = :username
                LIMIT 1
                ";

        $st = $this->con->prepare($sql);
        $st->execute([':username' => $username]);
        $result = $st->fetch();
        if (!$result || count($result) === 0) {
            return null;
        } else {
            return $this->getModel()::fromArray($result);
        }
    }

    public function fetchAllButOne(String $username): Array
    {
        $table = $this->getModel()::$table;

        $sql = "SELECT * FROM $table WHERE username != :username";

        $st = $this->con->prepare($sql);
        $st->execute(['username' => $username]);
        $result = $st->fetchAll();
        if (count($result) == 0) {
            return [];
        } else {
            return array_map(function ($row) {
                return $this->getModel()::fromArray($row);
            }, $result);
        }
    }
}
