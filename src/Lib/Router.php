<?php

namespace PhpTask\Lib;

class Router
{
    public $rotas;

    public function __construct()
    {
        $this->rotas = [];
    }

    public function add($method, $path, $controller, $action)
    {
        $this->rotas[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
        // array_push($rotas, []);
    }

    public function exibeDump()
    {
        echo "<pre>";
        var_export($this->rotas);
        echo "</pre>";
    }


    public function findRoute($method, $controller)
    {
        foreach ($this->rotas as $key => $rota) {
            if (
                $method == $rota['method']
                && $controller == $rota['controller']
            ) {
                return $rota;
            }
        }
        throw new \Exception("Not Found 404", 1);
    }
}
