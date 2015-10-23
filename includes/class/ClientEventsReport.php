<?php

/**
 * Created by PhpStorm.
 * User: paoolskoolsky
 * Date: 21.10.15
 * Time: 15:21
 */

public static function getRaportData()
{
    $pdo = new PDO('mysql:dbname=infoshareaca_5;host=sql.infoshareaca.nazwa.pl', 'infoshareaca_5', 'F0r3v3r!');
    $stmt = $pdo->query("Select e.idClient, nameClient as Client, count(*) AS 'events per month', month(dateOfEvent) AS month,
                   year(dateOfEvent) AS year
FROM events e
  INNER JOIN clients c
    on c.idClient = e.idClient
WHERE e.idClient = 1 and dateOfEvent < NOW() + INTERVAL 1 year and dateOfEvent <> 0
GROUP BY month(dateOfEvent) ORDER BY year(dateOfEvent) DESC, month(dateOfEvent) DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


?>