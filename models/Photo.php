<?php

class Photo extends Model {
    
    public function __construct($args = array()) {
        parent::__construct(array_merge(['table' => 'photos'], $args));
    }
    
    public function getComments($photoId) {
        return (new PhotoComments())->find(['where' => 'photo_id = '.$photoId]);
    }
    
}