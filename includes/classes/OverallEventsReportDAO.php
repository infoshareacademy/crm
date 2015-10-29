<?php

require_once 'DBConnection.php';

/**
 * Created by PhpStorm.
 * User: paoolskoolsky
 * Date: 27.10.15
 * Time: 15:50
 */
class OverallEventsReportDAO
{
protected $idClient;

    public function getReportData()
    {
        $query = "SELECT e.idClient, nameClient AS Client, count(*) AS eventsCount, month(dateOfEvent) AS month,
                  year(dateOfEvent) AS year FROM events e INNER JOIN clients c
                  ON c.idClient = e.idClient
                  WHERE dateOfEvent BETWEEN NOW() - INTERVAL 1 year and NOW() AND dateOfEvent <> 0
                  GROUP BY month(dateOfEvent), year(dateOfEvent), idClient ORDER BY idClient, year(dateOfEvent) DESC, month(dateOfEvent) DESC";

        $stmt = DBConnection::getConnection()->prepare($query);

        $input_parameters = array(':idClient' => $this->idClient);

        $status = $stmt->execute($input_parameters);

        if ($status > 0) {
            $reportData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo '#$%#&*&$%^@$%@$^#&@#$^';
        }
        return $reportData;
    }
}

