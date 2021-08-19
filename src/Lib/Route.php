<?php

namespace PhpTask\Lib;


class Route
{
    public $method;
    public $path;
    public $controller;
    public $action;

    private function __construct($method)
    {
        $this->method = $method;
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
