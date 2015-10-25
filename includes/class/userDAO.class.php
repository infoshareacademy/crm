<?php
include_once('../config/dbconnect.php');
//require_once 'user.class.php';
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
        $stmt->execute(array(
            ':loginUser' => $username
        ));
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            $user = new User($result['loginUser'], $result['passwordUser'], $result['roleUser']);
        }
        else {
            $user = new User('Guest', null, 0);
        }
        return $user;
    }

} //class User


