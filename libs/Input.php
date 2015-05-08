<?php

class Input {

    protected static $data = array();

    public static function get($name) {
        return self::$data[$name];
    }
    
    public static function all() {
        return self::$data;
    }

    public static function fillData($data) {
        self::$data = $data;
    }

}
