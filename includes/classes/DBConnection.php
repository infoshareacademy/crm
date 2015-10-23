<?php
/**
 * Created by PhpStorm.
 * User: katban
 * Date: 09.10.15
 * Time: 15:30
 */

class DBConnection {
    private static $connection;
    const hostname = "sql.infoshareaca.nazwa.pl";
    const db = "infoshareaca_5";
    const username = "infoshareaca_5";
    const pass = "F0r3v3r!";

    public static function getConnection()
    {
        if(!DBConnection::$connection) {
            try {
                DBConnection::$connection = new PDO ('mysql:host='.DBConnection::hostname.';port=3307;dbname='.DBConnection::db.';charset=utf8',DBConnection::username,DBConnection::pass);
            }
            catch (Exception $e) {
                echo 'Error database connection no. '.$e->getCode();
            }
        }
        return DBConnection::$connection;
    }
}