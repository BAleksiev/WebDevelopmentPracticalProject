<?php

class AlbumLikes extends Model {

    public function __construct($args = array()) {
        parent::__construct(array_merge(['table' => 'album_likes'], $args));
    }

    public function getMostRated($limit = 0) {

        $query = "SELECT COUNT(*) as rating, al.*, a.name FROM album_likes as al
                LEFT JOIN albums as a ON a.id = al.album_id
                GROUP BY album_id
                ORDER BY rating DESC
                LIMIT ".$limit;

        $result_set = $this->db->query($query);

        return $this->process_results($result_set);
    }

}
