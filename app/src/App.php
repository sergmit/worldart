<?php

namespace App;

use App\Controllers\MovieController;
use App\Database\DB;
use App\Helpers\StringHelper;
use App\Routers\Route;
use App\Views\View;
use Exception;

class App
{
    /**
     * @throws Exception
     */
    public static function init()
    {
        DB::init();
        Route::get('/movies', MovieController::class, 'index');
        Route::get('/', MovieController::class, 'index');
        $routesCollection = Route::getRouters();

        $routeParams = StringHelper::parseUri($_SERVER['REQUEST_URI']);

        View::getInstance()->getTwig()->addGlobal('route_params', $routeParams);

        $route = $routesCollection[$_SERVER['REQUEST_METHOD']][$routeParams->getPath()] ?? null;

        if (empty($route)) {
            return null;
        }

        $controller = new $route['controller']();
        $action = $route['action'];
        header('Content-type: text/html; charset=utf-8');
        echo $controller->{$action}($routeParams);
    }
}