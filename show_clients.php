<?php
/**
 * Created by PhpStorm.
 * User: katban
 * Date: 08.10.15
 * Time: 15:25
 */

$hostname = "sql.infoshareaca.nazwa.pl";
$db = "infoshareaca_5";
$username = "infoshareaca_5";
$pass = "F0r3v3r!";



$dbh = new PDO ("mysql:host=$hostname;port=3307;dbname=$db",$username,$pass);
$dbh->query("SET NAMES utf8");
$dbh->query("SET CHARACTER_SET utf8_polish_ci");

$sql = "SELECT * FROM clients";

$clients = $dbh->query($sql);

echo '<meta charset="utf8">';

echo '<table><tbody>';
foreach ($clients as $client) {
    echo '<tr>';
        echo '<td>';
            print $client['idClient'];
        echo '</td>';
        echo '<td>';
            print $client['nameClient'];
        echo '</td>';
        echo '<td>';
            print $client['idTax'];
        echo '</td>';
        echo '<td>';
            print $client['cityClient'];
        echo '</td>';
        echo '<td>';
            print $client['addressClient'];
        echo '</td>';
        echo '<td>';
            print $client['phoneClient'];
        echo '</td>';
        echo '<td>';
            print $client['faxClient'];
        echo '</td>';
        echo '<td>';
            print $client['wwwClient'];
        echo '</td>';
        echo '<td>';
            print $client['mailClient'];
        echo '</td>';
        echo '<td>';
            print $client['noteClient'];
        echo '</td>';
    //.' - '.$client['nameClient'].' - '.$client['idTax'].' - '.$client['cityClient'].' - '.'<br />';
    // idClient   |  nameClient   |  idTax  |  addressClient  |  cityClient  |  phoneClient  |  faxClient  |  wwwClient  |  mailClient  |  noteClient  | creationDateClient

    echo '</tr>';
}
echo '</tbody></table>';