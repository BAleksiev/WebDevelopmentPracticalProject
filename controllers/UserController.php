<?php

class UserController extends Controller {

    public function login() {

        if(!Auth::check()) {
            if($input = Input::all()) {

                $username = trim($input['username']);
                $password = trim($input['password']);

                if(Auth::attempt($username, $password)) {
                    redirect('profile');
                } else {
                    
                    // add errors for wrong username or pass <-----------------------------
                    
                    redirect('login');
                }
            } else {
                View::make('login', $this->data);
            }
        } else {
            redirect('index');
        }
    }

    public function register() {
        
    }

    public function logout() {
        Auth::logout();
        redirect('index');
    }
    
    public function profile() {
        if(!Auth::check()) {
            redirect('login');
        }
        
        $this->data['albums'] = $albums = (new User())->getAlbums(Auth::$user['id']);
        $this->data['user'] = Auth::$user;
        
        View::make('profile', $this->data);
        
    }

}
