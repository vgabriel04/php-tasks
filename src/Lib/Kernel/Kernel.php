<?php

namespace PhpTask\Lib\Kernel;

use PhpTask\Lib\Router;
use PhpTask\Lib\Kernel\Request;

//
class Kernel
{
    private $request;
    private $uri;
    private $method;
    private $router;

    public function boot()
    {
        $this->routerConfig();
        $this->handleRequest();
        $this->runAction();
    }

    private function handleRequest()
    {
        $uriTratamento = $_SERVER["REQUEST_URI"];
        $uriTratamento = explode('?', $uriTratamento);

        $uri = $uriTratamento[0];
        $method = $_SERVER["REQUEST_METHOD"];

        $json = file_get_contents("php://input");
        $request = Request::createFromJson($json);

        $this->uri = $uri;
        $this->method = $method;
        $this->request = $request;
    }

    private function routerConfig()
    {
        $this->router = RouterConfig::getRoutes();
        // acessando o método getRouter que é static "::"
    }

    private function runAction()
    {
        $rotaEncontrada = $this->router->findRoute($this->method, $this->uri);
        $nomeDaClasse = $rotaEncontrada->controller;
        $controller = new $nomeDaClasse();
        $response = $controller->{$rotaEncontrada->action}($this->request);
        // echo $response->process();
    }
}
