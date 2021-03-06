<?php
require_once 'vendors/password_compat/password.php';

require_once 'libs/Config.php';
require_once 'libs/functions.php';
require_once 'libs/Input.php';
require_once 'libs/Route.php';
require_once 'libs/Database.php';
require_once 'libs/Auth.php';
require_once 'libs/Session.php';
require_once 'libs/Controller.php';
require_once 'libs/Model.php';
require_once 'libs/View.php';

require_once 'routes.php';

require_once 'vendors/Smarty/Smarty.class.php';

class App {

    public static $requestRoute;
    public static $currentRoute;
    public static $routeAction;
    public static $routeArgs;

    function __construct() {

        try {
            $this->autoInclude();

            // Validate route and specified method
            self::$requestRoute = $_GET['url'];
            $route = Route::checkRoute(self::$requestRoute);
            self::$currentRoute = $route['route'];
            self::$routeAction = $route['action'];
            Route::checkAction(self::$routeAction);
            self::$routeArgs = Route::getRouteArgs(self::$currentRoute, self::$requestRoute);
            
            new Auth();

            // Call method specified in the route
            $this->executeAction(self::$routeAction, self::$routeArgs);
        } catch (Exception $ex) {
            View::make('error', ['error' => $ex]);
        }
        
        Session::clearMessages();
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
