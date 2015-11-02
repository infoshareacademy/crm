<?php

require_once __DIR__ . '/ClientEventsReportDAO.php';
require_once __DIR__ . '/ClientEventsReport.php';

class ClientEventsReportPresenter
{

    public function display($idClient) {
        $dao = new ClientEventsReportDAO();
        $data = $dao->getReportData($idClient);
        $reports = [];
        if (!$data) {
            return "<div class='col-xs-9 col-sm-7 col-lg-6'>
                    <div class='alert alert-danger' role='alert'>
                    <span class='fa fa-exclamation' aria-hidden='true'></span>
                    <span class='sr-only'>Error:</span>Oups, apparently you haven't any registered contact with this Client!</div>
                    </div>";
        } else {
            foreach($data as $monthlyData) {
                $report = new ClientEventsReport();
                $report->fillData($monthlyData);
                $reports[] = $report;
            }
        }
        return $this->drawReport($reports);
    }

    protected function drawReport(/* [ClientEventsReport] */$reports) {
        $output = "";
        $output .= "<div class='col-xs-9 col-sm-7 col-lg-6'>
                    <div class='alert alert-success' role='alert'>
                    <span class='fa fa-star' aria-hidden='true'></span>
                    <span class='sr-only'>Success:</span>Report for
                ". $reports[0]->nameClient.":</div>
                <div class='col-xs-8 col-sm-6'>
                <table class='table'>
                    <thead>
                    <tr>
                        <th class='col-sm-2'>count</th>
                        <th class='col-sm-2'>month</th>
                        <th class='col-sm-2'>year</th>
                    </tr>
                    </thead>
                    <tbody>";
        foreach ($reports as $item) {
            $output .= '<tr>
                            <td>'. $item->countByMonth .'</td>
                            <td>'. $item->month .'</td>
                            <td>'. $item->year .'</td>
                        </tr>';
        }

            $output .= '</tbody>
                    </table></div>';
        return $output;
    }

}