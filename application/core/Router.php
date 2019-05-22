<?php

namespace application\core;

class Router
{
    protected $routes = [];
    protected $currentRoute = [];

    function __construct() {
        $allRoutes = require 'application/config/routes.php';
        $this->addRoutes($allRoutes);
        $this->addCurrentRoute($this->routes);
    }

    public function addRoutes($allRoutes) {
        foreach ($allRoutes as $strRoute => $arrRoute) {
            $strRoute = '#^' . $strRoute . '$#';
            $this->routes[$strRoute] = $arrRoute;
        }
    }

    public function addCurrentRoute($routes)
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        foreach ($routes as $urlRoute => $arrRoute) {
            if (preg_match($urlRoute, $url))
                $this->currentRoute = $arrRoute;
        }
    }

    public function run() {
        if (isArrayFull($this->currentRoute) ) {
            $controllerPath = 'application\controllers\\' . ucfirst($this->currentRoute['controller']) . 'Controller';
            if (isClassExists($controllerPath) ) {
                $actionMethod = $this->currentRoute['action'] . 'Action';
                if (isMethodExists($controllerPath, $actionMethod) ) {
                    $controller = new $controllerPath($this->currentRoute);
                    $controller->$actionMethod();
                }
            }
        }
    }
}