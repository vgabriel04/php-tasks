<?php

require_once './vendor/autoload.php';

use PhpTask\Lib\Router;

$request = file_get_contents("php://input");
$request = json_decode($request);
if ($request == null)
  $request = new stdClass();

foreach ($_GET as $key => $value) {
  $request->$key = $value;
}

$uriTratamento = $_SERVER["REQUEST_URI"];
$uriTratamento = explode('?', $uriTratamento);
$uri = $uriTratamento[0];
$method = $_SERVER["REQUEST_METHOD"];

$router = new Router(); //para instanciar a classe: new "Nome da classe"

$router->get('/task', 'TaskController', 'index');
$router->get('/task/find', 'TaskController', 'find');
$router->post('/task', 'TaskController', 'create');
$router->put('/task', 'TaskController', 'update');
$router->delete('/task', 'TaskController', 'delete');
$router->get('/task/concluir', 'TaskController', 'concluir');

$rotaEncontrada = $router->findRoute($method, $uri);

$nomeDaClasse = "PhpTask\\Controller\\$rotaEncontrada->controller";
$controller = new $nomeDaClasse();
$response = $controller->{$rotaEncontrada->action}($request);
// echo $response->process();
