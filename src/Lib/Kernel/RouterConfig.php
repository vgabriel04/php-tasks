<?php

namespace PhpTask\Lib\Kernel;

use PhpTask\Lib\Route;
use PhpTask\Lib\Router;
use PhpTask\Controller\TaskController;
use PhpTask\Controller\SituacaoController;
use PhpTask\Controller\AccessController;

abstract class RouterConfig
{
    public static function getRoutes()
    {
        $router = new Router();
        $router->get('/', AccessController::class, 'firstLoad');
        $router->get('/task', TaskController::class, 'index');
        $router->get('/task/find', TaskController::class, 'find');
        $router->post('/task', TaskController::class, 'create');
        $router->put('/task', TaskController::class, 'update');
        $router->delete('/task', TaskController::class, 'delete');
        $router->get('/task/concluir', TaskController::class, 'concluir');

        $router->get('/situacoes', SituacaoController::class, 'index');
        $router->get('/situacoes/find', SituacaoController::class, 'find');
        $router->post('/situacoes', SituacaoController::class, 'create');
        $router->put('/situacoes', SituacaoController::class, 'update');
        $router->delete('/situacoes', SituacaoController::class, 'delete');

        return $router;
    }
}
