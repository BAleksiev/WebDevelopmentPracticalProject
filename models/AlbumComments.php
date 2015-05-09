<?php

class AlbumComments extends Model {
    
    public function __construct($args = array()) {
        parent::__construct(array_merge(['table' => 'album_comments'], $args));
    }
    
}