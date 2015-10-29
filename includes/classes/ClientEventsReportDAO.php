<?php

require_once 'DBConnection.php';

class ClientEventsReportDAO
{
    protected $idClient;

    public function getReportData($idClient) {

        $query = "SELECT e.idClient, nameClient,
        count(*) AS countByMonth,
        month(dateOfEvent) AS month,
        year(dateOfEvent) AS year
        FROM events e INNER JOIN clients c on c.idClient = e.idClient
        WHERE e.idClient = :idClient AND dateOfEvent <> 0 AND dateOfEvent < NOW()
        GROUP BY nameClient, year(dateOfEvent), month(dateOfEvent)
        ORDER BY year(dateOfEvent), month(dateOfEvent)";

        $stmt = DBConnection::getConnection()->prepare($query);

        $input_parameters = array(':idClient' => $idClient);

        $status = $stmt->execute($input_parameters);

        if ($status>0) {
            $reportData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo 'Oups! Are you sure you have ever actually met this Client?';
        }
        return $reportData;
    }

}