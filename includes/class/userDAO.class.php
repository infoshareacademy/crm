<?php
include_once('../config/dbconnect.php');
/**
 * Created by PhpStorm.
 * User: katban
 * Date: 22.10.15
 * Time: 16:33
 */
class userDAO
{
    public function loadUser($username) {
        $stmt = DBConnection::getConnection()->prepare('SELECT * FROM users WHERE loginUser=:loginUser');
        $status = $stmt->execute(array(
            ':loginUser' => $username
        ));

        if($status > 0) {
            print_r($status);
        }
        else echo "cos nie tak";
    }

}

$ktos = new userDAO();
$ktos->loadUser('admin');