<?php
include_once 'userDAO.class.php';
/**
 * Created by PhpStorm.
 * User: katban
 * Date: 22.10.15
 * Time: 16:00
 */
class User
{
    public $login;
    public $pass;
    public $permissions;
    public $logged;

    public function __construct($login = null, $pass = null, $permissions = null) {
        $this -> login = $login;
        $this -> pass = $pass;
        $this -> permissions = $permissions;
        $this -> logged = false;
    }

    public function __set($param_name,$param_value) {
        $this->$param_name = $param_value;
    }

    public function login($userName) {
        $dbUser = new userDAO();
        $dbUser = $dbUser->loadUser($userName);
        if ($dbUser) {
            // find user in db
            if($dbUser->pass === $this->pass) {
                $this -> logged = true;
                $this -> login = $dbUser -> login;
                $this -> permissions = $dbUser ->permissions;
            }
            else echo '<p>Password error</p>';
        }
        else echo '<p>Login failed</p>';
        unset($dbUser);
    }

    public function logout($userName) {
        $this -> logged = false;
    }

    public function isLogged($userName) {
        if ($this -> logged) {
            return true;
        }
        else {
            return false;
        }
    }
}  // class User

//$userName = 'admin';
//$pass = 'admain';
//
//$uzytkownik = new User($userName, $pass, 2);
//$uzytkownik->login($uzytkownik->login, $uzytkownik->pass);

