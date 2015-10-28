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

    private static $aliveUser;

    const USER_ADMIN = 2;
    const USER_USER = 1;
    const USER_GUEST = 0;

    public function __construct($login = null, $pass = null, $permissions = null, $forTest=false) {
        if($forTest == true) {
            return;
        }

        session_start();
        if(isset($_SESSION['user'])) {
            $this->login = $_SESSION['user'];
            $this->permissions = $_SESSION['permissions'];
            $this->logged = true;
        }
        else {
            $this->logged = false;
        }
    }

    public function __get($param_name) {
        return $this->$param_name;
    }

    public function __set($param_name, $param_value) {
        $this->$param_name = $param_value;
    }

    public static function getUser() {
        if(!User::$aliveUser) {
            User::$aliveUser = new User();
        }
        return User::$aliveUser;
    }

    public function setPassword($pass) {
        $pass = md5($pass);
        $this->pass = $pass;
    }

    public function login($userName) {
        $dbUser = new userDAO();
        $permissions = $dbUser->autorization($this);

        if ($permissions != null) {
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
