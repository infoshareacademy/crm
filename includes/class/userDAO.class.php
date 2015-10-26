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

    public function autorization($object) {
        $stmt = DBConnection::getConnection()->prepare('SELECT roleUser FROM users WHERE loginUser=:loginUser AND passwordUser=:password');
        $stmt->execute(array(
            ':loginUser' => $object->name,
            ':password' => $object->pass
        ));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if($result) {
            return $result['roleUser'];
        }
        else return null;
    }

} //class User


