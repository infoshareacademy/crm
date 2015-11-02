<?php

require_once __DIR__ . '/../../classes/OverallEventsReportDisplay.php';

/**
 * Created by PhpStorm.
 * User: paoolskoolsky
 * Date: 28.10.15
 * Time: 16:49
 */
class OverallEventsReportDisplayTest extends PHPUnit_Framework_TestCase
{

    public function testDisplay()
    {
        $displayer = new OverallEventsReportDisplay();
        echo $displayer->display();
    }

    public function testDrawOneMonth()
    {
        // given
        $displayer = new OverallEventsReportDisplay();
        $oneMonthData = new OverallEventsReportsItem();
        $oneMonthData->fillData(array('year' => 1329, 'month' => 3, 'eventsCount' => 10));

        // when
        $resultHtml = $displayer->drawOneMonth($oneMonthData);

        // then
        $this->assertEquals($resultHtml, '<td>10</td>');
    }


}
