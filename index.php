<?php

use PhpTask\Lib\Router;

require_once './vendor/autoload.php';

$body = file_get_contents("php://input");
$body = json_decode($body, true);


$router = new Router();
$router->add('GET', '/pudim', 'CozinhaController', 'cozinhaPudim');
$router->add('GET', '/lasanha', 'CozinhaController', 'cozinhaLasanha');
$router->add('GET', '/assistirTv', 'SalaController', 'assistirTv');

$router->exibeDump();

var_export($router->findRoute('GET', 'SalaController'));




// $response = callController();
// echo $response->process();
