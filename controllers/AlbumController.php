<?php

class AlbumController extends Controller {
    
    public function category($name) {
        
        $this->data['category'] = $category = (new Category())->get_by_name($name);
        $this->data['albums'] = $albums = (new Category())->getAlbums($category[0]['id']);
        
        View::make('albums', $this->data);
    }
    
    public function userAlbums($userId) {
        
        $this->data['albums'] = $albums = (new User())->getAlbums($userId);
        
        View::make('albums', $this->data);
    }
    
    public function album($id) {
        
        $this->data['album'] = $album = (new Album)->get($id);
        $this->data['photos'] = $photos = (new Album)->getPhotos($album[0]['id']);
        
        View::make('album', $this->data);
    }
    
}