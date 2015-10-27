<?php
require_once __DIR__ . '/UserDAO.php';
/**
 * Created by PhpStorm.
 * User: katban
 * Date: 22.10.15
 * Time: 16:00
 */
class User
{
    protected $login;
    protected $pass;
    protected $permissions;
    protected $logged;

    public function __construct($login = null, $pass = null, $permissions = null) {
        $this -> login = $login;
        $this -> pass = $pass;
        $this -> permissions = $permissions;
        $this -> logged = false;
    }

    public function __get($param_name) {
        return $this->$param_name;
    }

    public function __set($param_name, $param_value) {
        $this->$param_name = $param_value;
    }

    public function setPassword($pass) {
        $pass = md5($pass);
        $this -> pass = $pass;
    }

    public function login($userName) {
        $dbUser = new userDAO();
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

}  // class User
