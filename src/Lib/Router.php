<?php

namespace PhpTask\Lib;

use PhpTask\Lib\Route;

class Router
{
    public array $routes;

    public function __construct()
    {
        $this->routes = [];
    }

    private function addRoute(Route $route, $path, $controller, $action)
    {
        $route->withPath($path)
            ->withController($controller)
            ->withAction($action);

        $this->routes[] = $route;
    }

    public function get($path, $controller, $action)
    {
        $route = Route::get();
        $route = $this->addRoute($route, $path, $controller, $action);
    }

    public function post($path, $controller, $action)
    {
        $route = Route::post();
        $route = $this->addRoute($route, $path, $controller, $action);
    }

    public function put($path, $controller, $action)
    {
        $route = Route::put();
        $route = $this->addRoute($route, $path, $controller, $action);
    }

    public function delete($path, $controller, $action)
    {
        $route = Route::delete();
        $route = $this->addRoute($route, $path, $controller, $action);
    }

    public function exibeDump()
    {
        echo "<pre>";
        var_export($this->routes);
        echo "</pre>";
    }
    public function findRoute($method, $path)
    {
        foreach ($this->routes as $key => $route) {
            if (
                $method == $route->method//acessar atrib. privado
                && $path == $route->path
            ) {
                return $route;
            }
        }
        throw new \Exception("Not Found 404", 1);
    }
}
