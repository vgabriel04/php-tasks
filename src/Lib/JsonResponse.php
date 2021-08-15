<?php

namespace PhpTask\Lib;

class JsonResponse
{
    public static function send($retorno, $codigo)
    {
        self::sendData($retorno);
        self::sendCode($codigo);
        self::endProgram();
    }

    private static function endProgram()
    {
        exit;
    }

    private static function sendCode($code)
    {
        http_response_code($code);
    }

    private static function sendData($data)
    {
        echo json_encode($data);
    }
}
