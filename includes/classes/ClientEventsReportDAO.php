<?php


class ClientEventsReportDAO
{
    protected $idClient;

    public function getReportData($idClient) {
        $query = "SELECT e.idClient, nameClient,
        count(*) AS eventsCount,
        month(dateOfEvent) AS month,
        year(dateOfEvent) AS year
        FROM events e INNER JOIN clients c on c.idClient = e.idClient
        WHERE e.idClient = 1 AND dateOfEvent <> 0 AND dateOfEvent < NOW()
        GROUP BY nameClient, year(dateOfEvent), month(dateOfEvent)
        ORDER BY year(dateOfEvent), month(dateOfEvent)";

        $input_parameters = array(':idClient' => $idClient);

        $stmt = DBConnection::getConnection()->prepare($query);

        $status = $stmt->execute($input_parameters);

        if ($status>0) {
            $reportData = $status->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo 'Oups! Are you sure yu have ever actually met this Client?';
        }
        return $reportData;
    }

}