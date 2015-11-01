<?php

require_once __DIR__ . '/ClientEventsReportDAO.php';
require_once __DIR__ . '/ClientEventsReport.php';

class ClientEventsReportPresenter
{

    public function display($idClient) {
        $dao = new ClientEventsReportDAO();
        $data = $dao->getReportData($idClient);
        $reports = [];
        foreach($data as $monthlyData) {
            $report = new ClientEventsReport();
            $report->fillData($monthlyData);
            $reports[] = $report;
        }
        return $this->drawReport($reports);
    }

    protected function drawReport(/* [ClientEventsReport] */$reports) {
        $output = '';
        $output .= '</br><p>Report for
                '. $reports[0]->nameClient .':</p></br></br>
                <div class="col-xs-8 col-sm-6" ><table class="table">
                    <thead>
                    <tr>
                        <th class="col-sm-2">count</th>
                        <th class="col-sm-2">month</th>
                        <th class="col-sm-2">year</th>
                    </tr>
                    </thead>
                    <tbody>';
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