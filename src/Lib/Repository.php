<?php

namespace PhpTask\Lib;

use PhpTask\Lib\DbConnection;
use Exception;

class Repository
{
    protected $entity;

    protected function __construct($classname)
    {
        $this->entity = $classname;
    }

    public static function forClass($classname)
    {
        $repository = new Repository($classname);
        return $repository;
    }

    public function findAll($orderByColumn = null, $orderByOrder = null)
    {

        $entity = $this->entity;
        $tablename = $entity::tablename;

        $pdo = DbConnection::get();
        $sql = "select * from $tablename";

        if ($orderByColumn != null && ($orderByOrder == 'asc' || $orderByOrder == 'desc')) {
            $sql .= " order by $orderByColumn $orderByOrder";
        } elseif ($orderByColumn != null && ($orderByOrder != 'asc' || $orderByOrder != 'desc')) {
            throw new Exception("Você tentou realizar um orderBy, mas passou $orderByOrder ou $orderByOrder digitados incorretamente.");
        }

        $statement = $pdo->prepare($sql);

        if (!$statement->execute()) {
            throw new Exception("Erro de banco!");
        }

        $arrayData = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $objects = [];
        foreach ($arrayData as $key => $data) {
            $object = $entity::mapArrayToObject($data);
            array_push($objects, $object);
        }
        return $objects;
    }

    public function insert($values)
    {
        $entity = $this->entity;
        $tablename = $entity::tablename;

        $fields = array_keys($values);
        $fields = implode(',', $fields);

        $binds = array_pad([], count($values), '?');
        $binds = implode(',', $binds);

        $values = array_values($values);

        $pdo = DbConnection::get();

        $sql = "insert into $tablename ($fields) values ($binds)";

        $statement = $pdo->prepare($sql);

        if (!$statement->execute($values)) {
            throw new Exception("Erro de banco!");
        }
    }
}
