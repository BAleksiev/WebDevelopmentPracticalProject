<?php

class AlbumController extends Controller {
    
    public function category($name) {
        
        $name = trim(esc($name));
        
        $this->data['category'] = $category = (new Category())->get_by_name($name);
        $this->data['albums'] = $albums = (new Category())->getAlbums($category[0]['id']);
        
        View::make('albums', $this->data);
    }
    
    public function userProfile($userId) {
        
        $userId = (int)$userId;
        if($userId == 0) {
            redirect('index');
        }
        
        $this->data['albums'] = $albums = (new User())->getAlbums($userId);
        $this->data['user'] = $user = (new User())->get($userId)[0];
        
        if(!$user) {
            redirect('profile');
        }
        
        View::make('profile', $this->data);
    }
    
    public function album($id) {
        
        $id = (int)$id;
        if($id == 0) {
            redirect('index');
        }
        
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
            
            $album['name'] = trim(esc($input['name']));
            $album['description'] = trim(esc($input['description']));
            $album['user_id'] = Auth::$user['id'];
            $album['category_id'] = (int)$input['category'];
            
            if($album['category_id'] == 0) {
                Session::put(['Invalid category.'], 'error');
                redirect('profile');
            }
            
            if((new Album)->add($album)) {
                Session::put(['Album created.'], 'success');
            }
            
            redirect('profile');
        } else {
            View::make('create_album', $this->data);
        }
    }
    
    public function comment($albumId) {
        
        $albumId = (int)$albumId;
        if($albumId == 0) {
            redirect('index');
        }
        
        if(!Auth::check()) {
            redirect('album/'.$albumId);
        }
        
        $commentDto['comment'] = trim(esc(Input::get('comment')));
        $commentDto['user_id'] = Auth::$user['id'];
        $commentDto['album_id'] = (int)$albumId;
        $commentDto['date_created'] = date("Y-m-d H:i:s");
        
        if($commentDto['album_id'] == 0) {
            Session::put(['Invalid album.'], 'error');
            redirect('index');
        }
        
        if(!(new AlbumComments)->add($commentDto)) {
            Session::put(['Error submiting the comment.'], 'error');
        }
        
        redirect('album/'.$albumId);
    }
    
    public function like($albumId) {
        
        $albumId = (int)$albumId;
        if($albumId == 0) {
            redirect('index');
        }
        
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
        
        $albumId = (int)$albumId;
        if($albumId == 0) {
            redirect('index');
        }
        
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