<?php

class PhotoController extends Controller {

    public function photo($id) {

        $this->data['photo'] = $photo = (new Photo)->get($id)[0];

        $this->data['prev_photo'] = $prev_photo = (new Photo)->find(['where' => 'id < '.$id.' AND album_id = '.$photo['album_id'], 'order' => 'id DESC', 'limit' => 1])[0];
        $this->data['next_photo'] = $next_photo = (new Photo)->find(['where' => 'id > '.$id.' AND album_id = '.$photo['album_id'], 'limit' => 1])[0];

        $this->data['owner'] = $owner = (new User)->get($photo['user_id'])[0];
        $this->data['album'] = $album = (new Photo)->getAlbum($photo['album_id'])[0];

        $this->data['comments'] = $comments = (new Photo)->getComments($photo['id']);

        View::make('photo', $this->data);
    }

    public function upload($albumId) {

        if(!Auth::check()) {
            redirect('index');
        }

        $this->data['album'] = $album = (new Album)->get($albumId)[0];

        View::make('upload', $this->data);
    }

    public function proccessUpload($albumId) {

        if(!Auth::check()) {
            redirect('index');
        }

        $description = trim(Input::get('description'));

        $photo = Input::get('photo');

        $format = explode('/', $photo['type'])[1];

        if($format == 'jpeg') {
            $format = 'jpg';
        }

        if($format != 'jpg' && $format != 'png') {
            Session::put(['Invalid file format. Allowed formats: .jpg .png'], 'error');
        }

        // if size greater than 4 mb
        if((int)$photo['size'] > 4194304 || $photo['error'] == 1 || $photo['error'] == 2) {
            Session::put(['Image size is too big. Max 4 MB.'], 'error');
        }

        if($photo['error'] != 0) {
            Session::put(['Error uploading the photo.'], 'error');
        }

        if(!Session::messages('error')) {
            $photoDto['description'] = $description;
            $photoDto['format'] = $format;
            $photoDto['album_id'] = $albumId;
            $photoDto['user_id'] = Auth::$user['id'];
            $photoDto['upload_date'] = date("Y-m-d H:i:s");

            $photoId = (new Photo)->add($photoDto);

            move_uploaded_file($photo['tmp_name'], 'storage/'.$photoId.'.'.$format);
        }
        
        redirect('album/'.$albumId);
    }

    public function comment($photoId) {

        if(!Auth::check()) {
            redirect('photo/'.$photoId);
        }

        // validate data
        $comment = trim(Input::get('comment'));

        $commentDto['comment'] = $comment;
        $commentDto['user_id'] = Auth::$user['id'];
        $commentDto['photo_id'] = (int)$photoId;
        $commentDto['date_created'] = date("Y-m-d H:i:s");

        if(!(new PhotoComments)->add($commentDto)) {
            Session::put(['Error submiting the comment.'], 'error');
        }
        
        redirect('photo/'.$photoId);
    }

}
