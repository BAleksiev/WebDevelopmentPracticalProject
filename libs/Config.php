<?php

class Config {
    
    public static function get($request) {
        $params = explode('.', $request);
        
        $file = $params[0];
        
        if(file_exists('config/'.$file.'.php')) {
            
            $config = include 'config/'.$file.'.php';
            
            if(count($params) > 1) {
                return $config[$params[1]];
            } else {
                return $config;
            }
        } else {
            throw new Exception('Config file "'.$file.'.php" not exists');
        }
    }
    
}