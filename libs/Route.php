<?php

class Route {

    public static $routes = array();
    public static $controller;
    public static $method;

    public static function create($route, $action) {
        self::createRoute($route, $action);

        if($_POST || $_FILE) {
            
            $data = array_merge($_POST, $_FILE);
            
            Input::fillData($data);
        }
    }

    private static function createRoute($route, $action) {
        self::$routes[$route] = $action;
    }

    public static function checkRoute($requestRoute) {

        if(!$requestRoute || $requestRoute == 'index') {
            $requestRoute = '/';
        }

        $requestRouteParams = explode('/', $requestRoute);

        foreach(self::$routes as $route => $action) {
            $routeParams = explode('/', $route);

            if(count($routeParams) == count($requestRouteParams)) {

                $allParamsMatch = true;
                foreach($routeParams as $key => $param) {
                    if($param != $requestRouteParams[$key] && strpos($param, '{') === false) {
                        $allParamsMatch = false;
                    }
                }

                if($allParamsMatch) {
                    return array(
                        'route' => $route,
                        'action' => $action
                    );
                }
            }
        }

        throw new Exception('Route "'.$requestRoute.'" not found.');
    }

    public static function checkAction($action) {

        $actionParams = explode('@', $action);

        self::$controller = $actionParams[0];
        self::$method = $actionParams[1];

        if(!class_exists(self::$controller)) {
            throw new Exception('Controller "'.self::$controller.'" not exists.');
        }

        if(!method_exists(self::$controller, self::$method)) {
            throw new Exception('Method "'.self::$method.'" not exists in "'.self::$controller.'"');
        }
    }

    public static function getRouteArgs($currentRoute, $requestRoute) {

        $currentRouteParams = explode('/', $currentRoute);
        $requestRouteParams = explode('/', $requestRoute);

        $args = array();

        foreach($currentRouteParams as $key => $param) {
            if(strpos($param, '{') !== false) {
                $args[] = $requestRouteParams[$key];
            }
        }

        return $args;
    }

}
