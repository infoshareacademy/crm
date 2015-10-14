<?php

/**
 * Created by PhpStorm.
 * User: katban
 * Date: 14.10.15
 * Time: 15:46
 */
class Client {
    protected $id;
    protected $name;
    protected $idTax;
    protected $address;
    protected $city;
    protected $phone;
    protected $fax;
    protected $www;
    protected $mail;
    protected $note;
    protected $date;


    public function __construct($table=null) {
        if (isset ($table)) {
            foreach ($table as $key=>$value) {
                $this->$key = $value;
            }
        }
    }


}