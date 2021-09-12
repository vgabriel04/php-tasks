<?php

namespace PhpTask\Model;

use stdClass;

class Model
{
    //mapeamento de array para objeto
    public static function mapArrayToObject($arr)
    {
        $object = new static();
        foreach ($arr as $key => $value) {
            $object->$key = $value;
        }
        return $object;
    }
}
