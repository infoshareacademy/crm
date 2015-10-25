<?php
require_once __DIR__ . '/../config/dbconnect.php';
require_once 'user.class.php';

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
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $user = new User($result['loginUser'], $result['passwordUser'], $result['roleUser']);
            return $user;
        }
        else {
            return false;
        }
    }

} //class User


