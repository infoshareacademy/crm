<?php
/**
 * Created by PhpStorm.
 * User: katban
 * Date: 09.10.15
 * Time: 15:30
 */
$hostname = "sql.infoshareaca.nazwa.pl";
$db = "infoshareaca_5";
$username = "infoshareaca_5";
$pass = "F0r3v3r!";

//nawiazanie polaczenia
$dbh = new PDO ("mysql:host=$hostname;port=3307;dbname=$db;charset=utf8",$username,$pass);
