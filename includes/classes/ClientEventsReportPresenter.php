<?php


class ClientEventsReportPresenter
{

    public function display($idClient) {
        $dao = new ClientEventsReportDAO();
        $data = $dao->getReportData($idClient);
        $reports = [];
        foreach($data as $oneReportData) {
            $report = new ClientEventsReport();
            $report->fillData($oneReportData);
            $reports[] = $report;
        }
        return drawReport($reports);
    }

    protected function drawReport(/* [ClientEventsReport] */$reports) {
        $output = '';
        $output = '<table>';
        foreach ($reports as $item)

        return '<div>';
    }

}