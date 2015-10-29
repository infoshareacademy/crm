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
        $html = '<table>';
        foreach($reportsData as $oneClientReport) {
            $html .= $this->drawOneClient($oneClientReport);
        }
        $html .= '</table>';
        return $html;
    }

    function drawOneClient($oneClientReport) {
        $oneRowHtml = '<tr><td>'.$oneClientReport->getNameClient().'</td>';
        foreach($oneClientReport->getCountByMonth() as $oneMonthReportData) {
            $oneRowHtml .= $this->drawOneMonth($oneMonthReportData);
        }
        $oneRowHtml .= '</tr>';
        return $oneRowHtml;
    }

    function drawOneMonth($oneMonthReportData) {
        return '<td>'.$oneMonthReportData->getEventsCount().'</td>';
    }
}