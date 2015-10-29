<?php

/**
 * Created by PhpStorm.
 * User: paoolskoolsky
 * Date: 27.10.15
 * Time: 15:50
 */
require_once __DIR__ . '/DBConnection.php';

class OverallEventsReport
{
    protected $idClient;
    protected $nameClient;
    protected $countByMonth = array();

    public function init($reportData)
    {
        if (count($reportData) == 0)
        {
            throw new Exception();
        }
        $this->idClient = $reportData['idClient'];
        $this->nameClient = $reportData['Client'];
    }

    public function addMonthData($reportData)
    {
        $overallEventsReportsItem = new OverallEventsReportsItem();
        $overallEventsReportsItem->fillData($reportData);
        $this->countByMonth[] = $overallEventsReportsItem;
    }

    /**
     * @return mixed
     */
    public function getIdClient()
    {
        return $this->idClient;
    }

    /**
     * @return mixed
     */
    public function getNameClient()
    {
        return $this->nameClient;
    }

    /**
     * @return array
     */
    public function getCountByMonth()
    {
        return $this->countByMonth;
    }


}

class OverallEventsReportsItem
{
    protected $year;
    protected $month;
    protected $eventsCount;

    public function fillData($reportData)
    {
        $this->year = $reportData['year'];
        $this->month = $reportData['month'];
        $this->eventsCount = $reportData['eventsCount'];
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return mixed
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * @return mixed
     */
    public function getEventsCount()
    {
        return $this->eventsCount;
    }


}
