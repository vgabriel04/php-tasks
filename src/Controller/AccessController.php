<?php

namespace PhpTask\Controller;

use PhpTask\Lib\JsonResponse;

class AccessController
{

    public function __construct()
    {
    }

    public function firstLoad($request)
    {
        header('Location: lista-tarefas.html');
    }
}
