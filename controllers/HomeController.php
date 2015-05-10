<?php

class HomeController extends Controller {
    
    public function index() {
        
        $this->data['categories'] = $categories = (new Category())->find();
        
        $this->data['top_albums'] = $topAlbums = (new AlbumLikes())->getMostRated(8);
        
        View::make('index', $this->data);
    }
    
}