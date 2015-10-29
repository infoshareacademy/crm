<?php

require_once __DIR__ . '/DBConnection.php';

class ClientEventsReportDAO
{
    protected $query = "SELECT e.idClient, nameClient,
        count(*) AS countByMonth,
        month(dateOfEvent) AS month,
        year(dateOfEvent) AS year
        FROM events e INNER JOIN clients c on c.idClient = e.idClient
        WHERE e.idClient = :idClient AND dateOfEvent <> 0 AND dateOfEvent < NOW()
        GROUP BY nameClient, year(dateOfEvent), month(dateOfEvent)
        ORDER BY year(dateOfEvent), month(dateOfEvent)";

    public function getReportData($idClient) {

        $input_parameters = array(':idClient' => $idClient);

        $stmt = DBConnection::getConnection()->prepare($this->query);

        $status = $stmt->execute($input_parameters);

        if ($status>0) {
            $reportData = $status->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo 'Oups! Are you sure you have ever actually met this Client?';
        }
        return $reportData;
    }

}