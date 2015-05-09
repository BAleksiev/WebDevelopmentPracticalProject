<?php

class Auth {

    private static $is_logged_in = false;
    public static $user = array();

    public function __construct() {
        session_set_cookie_params(1800, "/");
        session_start();
        
        if(!empty($_SESSION['user']['username'])) {
            self::$is_logged_in = true;

            self::$user = $_SESSION['user'];
        }
    }

    public static function check() {
        return self::$is_logged_in;
    }

    public static function checkAdmin() {
        return self::$user['is_admin'] == 1 ? true : false;
    }

    public static function attempt($username, $password) {

        $db_object = Database::get_instance();
        $db = $db_object->get_db();

        $statement = $db->prepare(
                "SELECT * FROM users WHERE username = ? LIMIT 1"
        );

        $statement->bind_param('s', $username);

        $statement->execute();

        $result_set = $statement->get_result();

        if($user = $result_set->fetch_assoc()) {
            if(password_verify($password, $user['password'])) {
                $_SESSION['user']['id'] = $user['id'];
                $_SESSION['user']['username'] = $user['username'];
                $_SESSION['user']['is_admin'] = $user['is_admin'];

                self::$is_logged_in = true;

                self::$user = $_SESSION['user'];

                return true;
            }
        }

        return false;
    }
    
    public static function logout() {
        unset($_SESSION['user']);
    }

}
