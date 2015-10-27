<?php

require_once __DIR__ . '/DBConnection.php';

class ClientEventsReport
{
    protected $idClient;
    protected $nameClient;
    protected $countByMonth;
    protected $month;
    protected $year;

    public function fillData($oneReportData) {
        foreach ($oneReportData as $item){
        $this->idClient = $item['idClient'];
        $this->nameClient = $item['nameClient'];
        $this->countByMonth = $item['countByMonth'];
        $this->month = $item['month'];
        $this->year = $item['year'];
        }
    }
}
