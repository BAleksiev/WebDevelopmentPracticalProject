<?php

class Album extends Model {
    
    public function __construct($args = array()) {
        parent::__construct(array_merge(['table' => 'albums'], $args));
    }
    
    public function getPhotos($albumId, $userId = null) {
        $filter = '';
        
        if($userId) {
            $filter = ' AND user_id = '.$userId;
        }
        
        return (new Photo())->find(['where' => 'album_id = '.$albumId . $filter]);
    }
    
    public function getComments($albumId) {
        return (new AlbumComments())->find(['where' => 'album_id = '.$albumId]);
    }
}