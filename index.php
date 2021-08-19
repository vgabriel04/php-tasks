<?php

use PhpTask\Lib\Router;

require_once './vendor/autoload.php';

$body = file_get_contents("php://input");
$body = json_decode($body, true);


$router = new Router(); //para instanciar a classe: new "Nome da classe"

$router->get('/pudim', 'CozinhaController', 'cozinhaPudim');
$router->post('/lasanha', 'CozinhaController', 'cozinhaLasanha');
$router->put('/assistirTv', 'SalaController', 'assistirTv');
$router->delete('/jogarVideogame', 'SalaController', 'jogarVideogame');

$router->exibeDump();

var_dump($router->findRoute('DELETE', '/jogarVideogame'));


// $response = callController();
// echo $response->process();
