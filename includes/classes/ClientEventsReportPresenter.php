<?php


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
        return drawReport($reports);
    }

    protected function drawReport(/* [ClientEventsReport] */$reports) {
        $output = '';
        $output .= '<div class="nameClient">Report for
                '. $reports['nameClient'] .':</div></br></br>
                <table>
                    <thead>
                    <tr>
                        <th>count</th>
                        <th>month</th>
                        <th>year</th>
                    </tr>
                    </thead>
                    <tbody>';
        foreach ($reports as $item) {
            $output .= '<tr>
                            <td>'. $item['countByMonth'] .'</td>
                            <td>'. $item['month'] .'</td>
                            <td>'. $item['year'] .'</td>
                        </tr>';
        }

            $output .= '</tbody>
                    </table>';
        return $output;
    }

}