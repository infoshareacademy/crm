<?php

/**
 * Created by PhpStorm.
 * User: paoolskoolsky
 * Date: 21.10.15
 * Time: 16:12
 */
class ClientEventsReportDAO
{

    public function getReportData() {
        $query = "SELECT e.idClient, nameClient as Client,
        count(*) AS 'events per month',
        month(dateOfEvent) AS 'month',
        year(dateOfEvent) AS 'year'
        FROM events e INNER JOIN clients c on c.idClient = e.idClient
        WHERE e.idClient = 1 AND dateOfEvent <> 0
        GROUP BY Client, year(dateOfEvent), month(dateOfEvent)
        ORDER BY year(dateOfEvent), month(dateOfEvent)";

        $stmt = DBConnection::getConnection()->prepare($query);
        $input_parameters = array(':idClient' => $this->idClient);
        $status = $stmt->execute($input_parameters);

        if ($status>0) {
            $reportData = $status->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo 'Oups! Are you sure you have ever actually met this Client?';
        }

    }


}