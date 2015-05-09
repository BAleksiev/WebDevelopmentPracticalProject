<?php

class User extends Model {
    
    public function __construct($args = array()) {
        parent::__construct(array_merge(['table' => 'users'], $args));
    }
    
}