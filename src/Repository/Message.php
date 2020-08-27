<?php


namespace App\Repository;


class Message extends Repository
{
    public function getModel()
    {
        return \App\Model\Message::class;
    }

    public function fetchAllByIds($id1, $id2): Array
    {
        $table = $this->getModel()::$table;

        $sql = "
                    SELECT * FROM $table 
                    WHERE (fromMember = :id1 AND toMember = :id2) 
                    OR (fromMember = :id2 AND toMember = :id1)
                    ORDER BY  createdAt ASC
               ";

        $st = $this->con->prepare($sql);
        $st->execute([':id1' => $id1, ':id2' => $id2]);
        $result = $st->fetchAll();
        if (count($result) == 0) {
            return [];
        } else {
            return array_map(function ($row) {
                return $this->getModel()::fromArray($row);
            }, $result);
        }
    }

    public function insert(\App\Model\Message $message)
    {
        $table = $this->getModel()::$table;
        $sql = "
                    INSERT INTO $table (fromMember, toMember, message, createdAt)
                    values (:fromMember, :toMember, :message, :createdAt)
               ";
        $st = $this->con->prepare($sql);
        $st->execute([
            ":fromMember" => $message->getFromMember(),
            ":toMember" => $message->getToMember(),
            ":message" => $message->getMessage(),
            ":createdAt" => $message->getCreatedAt()->format('Y:m:d H:i:s'),
        ]);
    }
}