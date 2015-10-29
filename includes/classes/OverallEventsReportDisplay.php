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
        $html = '<table> <th><td>X 2015</td><td>IX 2015</td><td>VIII 2015</td><td>VII 2015</td><td>VI 2015</td><td>V 2015</td><td>IV 2015</td><td>III 2015</td><td>II 2015</td><td>I 2015</td><td>XII 2014</td><td>XI 2014</td></th>';
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