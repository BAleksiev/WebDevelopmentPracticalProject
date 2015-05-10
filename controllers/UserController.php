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
                    Session::put(['Wrong username or password.'], 'error');
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
        if($input = Input::all()) {

            // validate data
            
            $username = trim($input['username']);
            $password = trim($input['password']);

            $db_object = Database::get_instance();
            $db = $db_object->get_db();

            $statement = $db->prepare(
                    "SELECT * FROM users WHERE username = ? LIMIT 1"
            );

            $statement->bind_param('s', $username);
            $statement->execute();
            $result_set = $statement->get_result();

            if($user = $result_set->fetch_assoc()) {
                Session::put(['Username "'.$username.'" already exists.'], 'error');
                
                redirect('register');
            } else {
                $user['username'] = $username;
                $user['password'] = password_hash($password, PASSWORD_BCRYPT);
                
                if((new User)->add($user)) {
                    redirect('login');
                } else {
                    throw new Exception('Error creating user.');
                }
            }
        } else {
            View::make('register', $this->data);
        }
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
