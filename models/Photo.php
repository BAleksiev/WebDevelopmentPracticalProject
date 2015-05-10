<?php

class Photo extends Model {
    
    public function __construct($args = array()) {
        parent::__construct(array_merge(['table' => 'photos'], $args));
    }

    public function getComments($photoId) {

        $query = "SELECT pc.*, u.username FROM photo_comments as pc
                    LEFT JOIN users as u ON u.id = pc.user_id 
                    WHERE photo_id = {$photoId} ORDER BY date_created DESC";

        $result_set = $this->db->query($query);

        return $this->process_results($result_set);
    }
    
    public function getAlbum($albumId) {
        return (new Album())->get($albumId);
    }
    
}