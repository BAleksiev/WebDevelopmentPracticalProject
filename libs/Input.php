<?php

class Input {

    protected static $data = array();
    protected static $files = array();

    public static function get($name) {
        
        if(self::$data[$name]) {
            return self::$data[$name];
        } else if(self::$files[$name]) {
            return self::$files[$name];
        }
        
        return false;
    }
    
    public static function all() {
        return array_merge(self::$data, self::$files);
    }
    
    public static function files() {
        return self::$files;
    }

    public static function fillData($data) {
        self::$data = $data;
    }
    
    public static function fillFileData($data) {
        self::$files = $data;
    }

}
