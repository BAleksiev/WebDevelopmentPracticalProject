<?php

class AlbumController extends Controller {
    
    public function category($name) {
        
        $this->data['category'] = $category = (new Category())->get_by_name($name);
        $this->data['albums'] = $albums = (new Category())->getAlbums($category[0]['id']);
        
        View::make('albums', $this->data);
    }
    
    public function userProfile($userId) {
        
        $this->data['albums'] = $albums = (new User())->getAlbums($userId);
        $this->data['user'] = $user = (new User())->get($userId)[0];
        
        if(!$user) {
            redirect('profile');
        }
        
        View::make('profile', $this->data);
    }
    
    public function album($id) {
        
        $this->data['album'] = $album = (new Album)->get($id);
        $this->data['photos'] = $photos = (new Album)->getPhotos($album[0]['id']);
        $this->data['comments'] = $comments = (new Album)->getComments($album[0]['id']);
        $like = (new AlbumLikes)->find(['where' => 'album_id = '.$id.' AND user_id = '.Auth::$user['id']])[0];
        
        if($like) {
            $this->data['like'] = true;
        }
        
        View::make('album', $this->data);
    }
    
    public function createAlbum() {
        
        if(!Auth::check()) {
            redirect('login');
        }
        
        $this->data['categories'] = $categories = (new Category())->find();
        
        if($input = Input::all()) {
            
            // validate data
            $album['name'] = trim($input['name']);
            $album['description'] = trim($input['description']);
            $album['user_id'] = Auth::$user['id'];
            $album['category_id'] = (int)$input['category'];
            
            if((new Album)->add($album)) {
                Session::put(['Album created.'], 'success');
            }
            
            redirect('profile');
        } else {
            View::make('create_album', $this->data);
        }
    }
    
    public function comment($albumId) {
        
        if(!Auth::check()) {
            redirect('album/'.$albumId);
        }
        
        // validate data
        $comment = trim(Input::get('comment'));
        
        $commentDto['comment'] = $comment;
        $commentDto['user_id'] = Auth::$user['id'];
        $commentDto['album_id'] = (int)$albumId;
        $commentDto['date_created'] = date("Y-m-d H:i:s");
        
        if(!(new AlbumComments)->add($commentDto)) {
            Session::put(['Error submiting the comment.'], 'error');
        }
        
        redirect('album/'.$albumId);
    }
    
    public function like($albumId) {
        
        if(!Auth::check()) {
            redirect('album/'.$albumId);
        }
        
        $like = (new AlbumLikes)->find(['where' => 'album_id = '.$albumId.' AND user_id = '.Auth::$user['id']]);
        
        if(!$like) {
            
            $like['user_id'] = Auth::$user['id'];
            $like['album_id'] = $albumId;
            
            (new AlbumLikes)->add($like);
        }
        
        redirect('album/'.$albumId);
    }
    
    public function dislike($albumId) {
        
        if(!Auth::check()) {
            redirect('album/'.$albumId);
        }
        
        $like = (new AlbumLikes)->find(['where' => 'album_id = '.$albumId.' AND user_id = '.Auth::$user['id']]);
        
        if($like) {
            
            (new AlbumLikes)->delete(['where' => 'album_id = '.$albumId.' AND user_id = '.Auth::$user['id']]);
        }
        
        redirect('album/'.$albumId);
    }
    
}