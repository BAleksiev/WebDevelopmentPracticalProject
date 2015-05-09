<?php

class Category extends Model {
    
    public function __construct($args = array()) {
        parent::__construct(array_merge(['table' => 'categories'], $args));
    }
    
    public function getAlbums($categoryId) {
        return (new Album())->find(['where' => 'category_id = '.$categoryId]);
    }
}