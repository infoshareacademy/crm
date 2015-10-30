<?php
/**
 * Created by PhpStorm.
 * User: katban
 * Date: 09.10.15
 * Time: 15:30
 */

class DBConnection {
    private static $connection;

    public static function getConnection()
    {
        if(!DBConnection::$connection) {
            try {
                $params = include(__DIR__ . '/../config/config.php');
                DBConnection::$connection = new PDO (
                    'mysql:host=' . $params['hostname'] .
                    ';port=3307;dbname=' . $params['db'] .
                    ';charset=utf8', $params['username'], $params['pass']);
            }
            catch (Exception $e) {
                echo 'Error database connection no. '.$e->getCode();
            }
        }
        return DBConnection::$connection;
    }
}