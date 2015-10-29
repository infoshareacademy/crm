<?php

require_once 'DBConnection.php';

class ClientEventsReport
{
    protected $idClient;
    protected $nameClient;
    protected $countByMonth;
    protected $month;
    protected $year;

    public function __set($param_name, $param_value) {
        $this->$param_name = $param_value;
    }

    public function __get($param_name) {
        return $this->$param_name;
    }

    public function fillData($reportData) {
        foreach ($reportData as $attribute => $value){
        $this->$attribute = $value;
        }
    }
}
