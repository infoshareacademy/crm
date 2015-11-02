<?php

require_once 'OverallEventsReportDAO.php';
require_once 'OverallEventsReport.php';

/**
 * Created by PhpStorm.
 * User: paoolskoolsky
 * Date: 27.10.15
 * Time: 15:51
 */
class OverallEventsReportDisplay
{
    public function display()
    {
        $dao = new OverallEventsReportDAO();
        $data = $dao->getReportData();
        $reports = array();
        foreach($data as $reportItemData)
        {
            $idClient = $reportItemData['idClient'];
            if(!isset($reports[$idClient])) {
                $overallEventsReport = new OverallEventsReport();
                $overallEventsReport->init($reportItemData);
                $reports[$idClient] = $overallEventsReport;
            }
            $reports[$idClient]->addMonthData($reportItemData);
        }
        return $this->drawReport($reports);
    }

    protected function drawReport($reportsData)
    {
        $html = '<table class="table table-striped table-hover table-condensed"> <thead><tr><th> </th><th>XI 2015</th><th>X 2015</th><th>IX 2015</th><th>VIII 2015</th><th>VII 2015</th><th>VI 2015</th><th>V 2015</th><th>IV 2015</th><th>III 2015</th><th>II 2015</th><th>I 2015</th><th>XII 2014</th></tr></thead>';
        foreach($reportsData as $oneClientReport) {
            $html .= $this->drawOneClient($oneClientReport);
        }
        $html .= '</table>';
        return $html;
    }

    function drawOneClient($oneClientReport) {
        $oneRowHtml = '<tr><td>' . $oneClientReport->getNameClient() . '</td>';
        $months = array();

        foreach($oneClientReport->getCountByMonth() as $oneMonthReportData) {
            $months[$oneMonthReportData->getMonth()] = $oneMonthReportData;
        }

        $currentMonthNumber = date('m');

        for ($i = 12; $i >= 1; $i--) {
            $n = ($i + $currentMonthNumber) % 12;
            if (isset($months[$n])) {
                $oneRowHtml .= '<td width="100">' . $this->drawOneMonth($months[$n]) . '</td>';
            } else {
                $oneRowHtml .= '<td width="100">0</td>';
            }
        }



        $oneRowHtml .= '</tr>';
        return $oneRowHtml;
    }

    function drawOneMonth($oneMonthReportData) {
        return $oneMonthReportData->getEventsCount();
    }
}