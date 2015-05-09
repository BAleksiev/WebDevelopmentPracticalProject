<?php

class User extends Model {
    
    public function __construct($args = array()) {
        parent::__construct(array_merge(['table' => 'users'], $args));
    }
    
    public function getAlbums($userId) {
        return (new Album())->find(['where' => 'user_id = '.$userId]);
    }
}