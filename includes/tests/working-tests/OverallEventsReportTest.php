<?php

/**
 * Created by PhpStorm.
 * User: paoolskoolsky
 * Date: 28.10.15
 * Time: 15:50
 */

require_once __DIR__ . '/../../classes/OverallEventsReport.php';

class OverallEventsReportTest extends PHPUnit_Framework_TestCase
{

    private $instance;

    public function testOneResultItem()
    {
        // given
        $instance = new OverallEventsReport();
        $idClient = 46563;
        $nameClient = 'test client name';
        $month = 7;
        $year = 1410;
        $eventsCount = 15;
        $reportData = $this->prepareReportData($idClient, $nameClient, $year, $month, $eventsCount);

        // when
        $instance->init($reportData);
        $instance->addMonthData($reportData);

        // then
        $this->assertEquals($instance->getIdClient(),$idClient);
        $this->assertEquals($instance->getNameClient(),$nameClient);
        $this->assertEquals(count($instance->getCountByMonth()),1);
        $this->verifyMonthReportItem($instance,$month, $year, $eventsCount, 0);

    }

    public function testSecontResultItemForTheSameCompany()
    {
        // given
        $instance = new OverallEventsReport();
        $idClient = 46563;
        $nameClient = 'test client name';
        $month = 7;
        $year = 1410;
        $eventsCount = 15;
        $reportData = $this->prepareReportData($idClient, $nameClient, $year + 100, $month + 2, $eventsCount + 2);
        $instance->init($reportData);
        $instance->addMonthData($reportData);
        $reportData = $this->prepareReportData($idClient, $nameClient, $year, $month, $eventsCount);

        // when
        $instance->addMonthData($reportData);

        // then
        $this->assertEquals(count($instance->getCountByMonth()),2);
        $this->verifyMonthReportItem($instance, $month, $year, $eventsCount, 1);

        print_r($instance);
    }
    /**
     * @param $idClient
     * @param $nameClient
     * @param $year
     * @param $month
     * @param $eventsCount
     * @return array
     */
    public function prepareReportData($idClient, $nameClient, $year, $month, $eventsCount)
    {
        $reportData = array('idClient' => $idClient, 'nameClient' => $nameClient, 'year' => $year, 'month' => $month, 'eventsCount' => $eventsCount);
        return $reportData;
    }

    /**
     * @param $instance
     * @param $month
     * @param $year
     * @param $eventsCount
     * @param $expectedItemIndex
     */
    public function verifyMonthReportItem($instance, $month, $year, $eventsCount, $expectedItemIndex)
    {
        $this->assertInstanceOf('OverallEventsReportsItem', $instance->getCountByMonth()[$expectedItemIndex]);
        $this->assertEquals($instance->getCountByMonth()[$expectedItemIndex]->getMonth(), $month);
        $this->assertEquals($instance->getCountByMonth()[$expectedItemIndex]->getYear(), $year);
        $this->assertEquals($instance->getCountByMonth()[$expectedItemIndex]->getEventsCount(), $eventsCount);
    }

}
