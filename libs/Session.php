<?php

class Session {
    
    public static function messages($type = null) {
        if($type) {
            return $_SESSION['messages'][$type];
        }
        
        return $_SESSION['messages'];
    }
    
    public static function put($messages, $type) {
        foreach($messages as $msg) {
            $_SESSION['messages'][$type][] = $msg;
        }
    }
    
    public static function clearMessages() {
        unset($_SESSION['messages']);
    }
    
}