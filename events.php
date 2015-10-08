<?php

$hostname = "sql.infoshareaca.nazwa.pl";
$db = "infoshareaca_5";
$username = "infoshareaca_5";
$pass = "F0r3v3r!";


$dbh = new PDO ("mysql:host=$hostname;port=3307;dbname=$db",$username,$pass);
$dbh->query("SET NAMES utf8");
$dbh->query("SET CHARACTER_SET utf8_polish_ci");

$sql = "SELECT * FROM events";

$events = $dbh->query($sql);

