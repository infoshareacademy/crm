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
//$dbh->query("SET CHARACTER_SET utf8_polish_ci");

//struktura tabeli
// idClient   |  nameClient   |  idTax  |  addressClient  |  cityClient  |  phoneClient  |  faxClient  |  wwwClient  |  mailClient  |  noteClient  | creationDateClient
$sql = "SELECT * FROM clients";
// tablica zawierajaca wszystkie rekordy z tabeli clients
$clients = $dbh->query($sql);

echo '<meta charset="utf8">';


echo '<table>';
// naglowek
echo '<thead>
            <tr><td>[ ID ]</td><td>[ Company ]</td><td>[ Tax ID ]</td><td>[ Adress ]</td><td>[ City ]</td><td>[ Phone ]</td><td>[ Fax ]</td><td>[ WWW ]</td><td>[ @ ]</td><td>[ Note ]</td>d><td>[ Date ]</td></tr>
        </thead>';

echo '<tbody>';
// wyswietlanie wynikow
foreach ($clients as $client) {
    echo '<tr>';
    $iloscElementow = count($client);
    for ($i=0; $i < $iloscElementow; $i++) {
        echo '<td>';
            echo $client[$i];
        echo '</td>';
    }
    echo '</tr>';
}
echo '</tbody></table>';