<?php
/**
 * Created by PhpStorm.
 * User: katban
 * Date: 08.10.15
 * Time: 15:25
 */

//struktura tabeli
// idClient   |  nameClient   |  idTax  |  addressClient  |  cityClient  |  phoneClient  |  faxClient  |  wwwClient  |  mailClient  |  noteClient  | creationDateClient
$sql = "SELECT * FROM clients";
$clients = $dbh->query($sql);

echo '<meta charset="utf8">';

echo '<table>';
// naglowek
echo '<thead>
            <tr><td>[ ID ]</td><td>[ Company ]</td><td>[ Tax ID ]</td><td>[ Adress ]</td><td>[ City ]</td><td>[ Phone ]</td><td>[ Fax ]</td><td>[ WWW ]</td><td>[ @ ]</td><td>[ Note ]</td><td>[ Date ]</td></tr>
        </thead>';

echo '<tbody>';
// wyswietlanie wynikow
foreach ($clients as $client) {
    echo '<tr>';
    $iloscElementow = count($client)/2;
    for ($i=0; $i < $iloscElementow; $i++) {
        echo '<td>';
            echo $client[$i];
        echo '</td>';
    }
    echo '</tr>';
}
echo '</tbody></table>';