<?php

require_once 'libs/Input.php';
require_once 'libs/Route.php';
require_once 'libs/Config.php';
require_once 'libs/Auth.php';
require_once 'libs/Controller.php';
require_once 'libs/Model.php';
require_once 'libs/View.php';

require_once 'routes.php';

class App {
    
    public static $requestRoute;
    public static $currentRoute;
    public static $routeAction;
    public static $routeArgs;

    function __construct() {
        
        $this->autoInclude();
        
        self::$requestRoute = $_GET['url'];
        $route = Route::checkRoute(self::$requestRoute);
        self::$currentRoute = $route['route'];
        self::$routeAction = $route['action'];
        Route::checkAction(self::$routeAction);
        self::$routeArgs = Route::getRouteArgs(self::$currentRoute, self::$requestRoute);
        
        $this->executeAction(self::$routeAction, self::$routeArgs);
    }
    
    private function autoInclude() {
        
        $directories = array(
            'controllers' => scandir('controllers'),
            'models' => scandir('models')
        );
        
        foreach($directories as $folder => $files) {
            foreach($files as $file) {
                if($file != '.' && $file != '..') {
                    require_once $folder.'/'.$file;
                }
            }
        }
    }
    
    private function executeAction($action, $args) {
        $actionParams = explode('@', $action);
        
        $controllerName = $actionParams[0];
        $methodName = $actionParams[1];
        
        $controller = new $controllerName;
        call_user_func_array([$controller, $methodName], $args);
    }

}