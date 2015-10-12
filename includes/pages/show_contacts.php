<?php
/**
 * Created by PhpStorm.
 * User: katban
 * Date: 09.10.15
 * Time: 16:25
 */

// do usuniecia przed marge'm
include('../../dbconnect.php');

//create query
// surnameContact, nameContact, positionContact, phoneContact, emailContact, cityContact linkedinContact, NoteContact
if (isset($_GET['id'])) {
    $getId = (int)$_GET['id'];
    $sql = 'SELECT surnameContact, nameContact, positionContact, phoneContact, emailContact, cityContact, linkedinContact, noteContact FROM contacts WHERE idClient='.$getId;
}
else
    $sql = "";

// execute query
$contacts = $dbh->query($sql);
$clients = $contacts->fetchAll(PDO::FETCH_ASSOC);

echo '<h1>Contacts from Client</h1>';


//each client has own table; display only cells with content
foreach ($clients as $clientId=>$client) {
    echo '<table>';
    foreach ($client as $attributeValue) {
        if ($attributeValue != '')
            echo '<tr><td>'.$attributeValue.' </td></tr>';
    }
    echo '</table>';
}

// 
if (count($clients) == 0)
    echo "That's a shame! This client hasn't contact";