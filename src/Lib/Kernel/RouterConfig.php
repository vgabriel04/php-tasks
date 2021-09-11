<?php

namespace PhpTask\Lib\Kernel;

use PhpTask\Lib\Route;
use PhpTask\Lib\Router;

abstract class RouterConfig
{
    public static function getRoutes()
    {
        $router = new Router();
        $router->get('/task', 'TaskController', 'index');
        $router->get('/task/find', 'TaskController', 'find');
        $router->post('/task', 'TaskController', 'create');
        $router->put('/task', 'TaskController', 'update');
        $router->delete('/task', 'TaskController', 'delete');
        $router->get('/task/concluir', 'TaskController', 'concluir');

        return $router;
    }
}
