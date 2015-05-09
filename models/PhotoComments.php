<?php

class PhotoComments extends Model {
    
    public function __construct($args = array()) {
        parent::__construct(array_merge(['table' => 'photo_comments'], $args));
    }
    
}