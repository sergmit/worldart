<?php

namespace App\Routers;

use Exception;

class Route
{
    protected static $routes = ['GET' => [], 'POST' => []];

    /**
     * @param string $url
     * @param string $controller
     * @param string $method
     * @throws Exception
     */
    public static function get(string $url, string $controller, string $method)
    {
        if (!class_exists($controller)) {
            throw new Exception("Controller $controller not found");
        }

        if (!method_exists($controller, $method)) {
            throw new Exception("Method $method not found");
        }

        self::$routes['GET'][$url] = ['controller' => $controller, 'action' => $method, 'method' => 'GET'];
    }

    /**
     * @return array
     */
    public static function getRouters(): array
    {
        return self::$routes;
    }
}