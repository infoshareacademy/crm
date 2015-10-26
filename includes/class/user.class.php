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
        switch ($param_name) {
            case 'pass':
                $param_value = md5($param_value);
                $this -> pass = $param_value;
                break;
            default:
                $this->$param_name = $param_value;
        }
    }

    public function login($userName) {
        $dbUser = new userDAO();
//        $dbUser = $dbUser->loadUser($userName);
//        if ($dbUser) {
//            // find user in db
//            if($dbUser->pass === $this->pass) {
//                $this -> logged = true;
//                $this -> login = $dbUser -> login;
//                $this -> permissions = $dbUser ->permissions;
//            }
//            else echo '<p>Password error</p>';
//        }
//        else echo '<p>Login failed</p>';
//        unset($dbUser);
        $permissions = $dbUser->autorization($this);
        if ($permissions) {
            //autoryzacja sie powiodla i zostal zwrocony poziom uprawnien
            $this->logged = true;
            $this->permissions = $permissions;
        }
        else {
            $this->logged = false;
        }
        $this->pass = null;
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


$haslo = 'admin2';
$skrot = md5($haslo);
echo $skrot;