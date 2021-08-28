<?php

namespace PhpTask\Lib;

use Exception;

class Route
{
    private $method;
    private $path;
    private $controller;
    private $action;

    private function __construct($method)
    {
        $this->method = $method;
    }

    public function setMethod($method)
    {
        if (
            $method !== 'GET' &&
            $method !== 'POST' &&
            $method !== 'PUT' &&
            $method !== 'DELETE'
        ) {
            throw new Exception("Metodo '$method' não aceito!");
        } else {
            $this->method = $method;
        }
    }

    public function __set($atrib, $value)
    {
        if ($atrib == 'method') {
            $this->setMethod($value);
        } else {
            $this->$atrib = $value;
        }
    }

    public function __get($atrib)
    {
        return $this->$atrib;
    }

    public static function get()
    {
        return new Route('GET');
    }
    public static function post()
    {
        return new Route('POST');
    }
    public static function put()
    {
        return new Route('PUT');
    }
    public static function delete()
    {
        return new Route('DELETE');
    }

    public function withPath($path)
    {
        $this->path = $path;
        return $this;
    }

    public function withController($controller)
    {
        $this->controller = $controller;
        return $this;
    }

    public function withAction($action)
    {
        $this->action = $action;
        return $this;
    }

   


}
