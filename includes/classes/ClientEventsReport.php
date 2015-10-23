<?php

/**
 * Created by PhpStorm.
 * User: paoolskoolsky
 * Date: 21.10.15
 * Time: 15:21
 */

require_once __DIR__ . '/DBConnection.php';

function getRaportData()
{
    $pdo = DBConnection::getConnection();
    $stmt = $pdo->query("Select e.idClient, nameClient as Client, count(*) AS 'events per month', month(dateOfEvent) AS month,
                   year(dateOfEvent) AS year
FROM events e
  INNER JOIN clients c
    on c.idClient = e.idClient
WHERE e.idClient = 1 and dateOfEvent < NOW() + INTERVAL 1 year and dateOfEvent <> 0
GROUP BY month(dateOfEvent) ORDER BY year(dateOfEvent) DESC, month(dateOfEvent) DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
