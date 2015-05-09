<?php

class Database {
    
    private static $db;
    
    private function __construct() {
        $db = Config::get('database');
        self::$db = new mysqli($db['host'], $db['username'], $db['password'], $db['database']);
    }
    
    public static function get_instance() {
        static $instance = null;
        
        if($instance === null) {
            $instance = new static();
        }
        
        return $instance;
    }
    
    public static function get_db() {
        return self::$db;
    }
}