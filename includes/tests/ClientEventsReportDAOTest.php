<?php

/**
 * Created by PhpStorm.
 * User: paoolskoolsky
 * Date: 21.10.15
 * Time: 16:12
 */
class ClientEventsReportDAOTest
{
    
    protected $reportData =array();

    public function setUp() {
        $this->reportData = new ClientEventsReportDAO();
    }

    public function ifEmpty() {
        $reportData = new ClientEventsReportDAO();
        $xxx = $reportData->loadData('');
    }
}