<?php

class Route {
    
    public static $routes = array();

    public static function create($route, $action) {
        self::createRoute($route, $action);
        
        if($_POST) {
            Input::fillData($_POST);
        }
    }
    
    private static function createRoute($route, $action) {
        self::$routes[$route] = $action;
    }
    
    public static function checkRoute($requestRoute) {
        
        if($requestRoute == 'index.php') {
            $requestRoute = '/';
        }
        
        $requestRouteParams = explode('/', $requestRoute);
        
        foreach(self::$routes as $route => $action) {
            $routeParams = explode('/', $route);
            
            if(count($routeParams) == count($requestRouteParams)) {
                foreach($routeParams as $key => $param) {
                    if($param != $requestRouteParams[$key] && strpos($param, '{') === false) {
                        throw new Exception('Route "'.$requestRoute.'" not found.');
                    }
                    
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
        
        $controller = $actionParams[0];
        $method = $actionParams[1];
        
        if(!class_exists($controller)) {
            throw new Exception('Controller "'.$controller.'" not exists.');
        }
        
        if(!method_exists($controller, $method)) {
            throw new Exception('Method "'.$method.'" not exists in "'.$controller.'"');
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