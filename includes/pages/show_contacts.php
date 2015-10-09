<?php
/**
 * Created by PhpStorm.
 * User: katban
 * Date: 09.10.15
 * Time: 16:25
 */

// do usuniecia przed marge'm
include('../../dbconnect.php');


if (isset($_GET['id'])) {
    $getId = (int)$_GET['id'];
    $sql = 'SELECT * FROM contacts WHERE idClient='.$getId;
}
else
    $sql = "SELECT * FROM contacts";
echo '<pre>';
//print_r($_GET);

// zapytanie do bazy
$contacts = $dbh->query($sql);

echo '<h1>Contacts from Client</h1>';
echo '<table>';

print_r($contacts);

foreach ($contacts as $key => $value) {
   // print_r($key);
}

echo '</table>';