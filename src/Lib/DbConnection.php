<?php

namespace PhpTask\Lib;

class DbConnection
{
    public static function get()
    {
        $pdo = new \PDO('pgsql:host=localhost;port=5432;dbname=phptask;', 'postgres', '123456', [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
        return $pdo;
    }
}
