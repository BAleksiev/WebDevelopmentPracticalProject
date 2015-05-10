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

        return (new Photo())->find(['where' => 'album_id = '.$albumId.$filter]);
    }

    public function getComments($albumId) {

        $query = "SELECT ac.*, u.username FROM album_comments as ac
                    LEFT JOIN users as u ON u.id = ac.user_id 
                    WHERE album_id = {$albumId} ORDER BY date_created DESC";

        $result_set = $this->db->query($query);

        return $this->process_results($result_set);
    }

}
