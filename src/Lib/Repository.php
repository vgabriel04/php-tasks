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

    public function findAll()
    {
        $entity = $this->entity;
        $tablename = $entity::tablename;

        $pdo = DbConnection::get();
        $sql = "select * from $tablename";
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
}
