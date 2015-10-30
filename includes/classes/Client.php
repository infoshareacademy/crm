<?php

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

//
//    public function __construct($table=null) {
//        if (isset ($table)) {
//            foreach ($table as $key=>$value) {
//                $this->$key = $value;
//            }
//        }
//    }

    // ograniczenia wynikajace z ustawien bazy danych; poza ograniczeniem pola note
    const NAME_MAX_LENGHT = 80;
    const IDTAX_LENGHT = 10;
    const ADDRESS_MAX_LENGHT = 255;
    const CITY_MAX_LENGHT = 25;
    const PHONE_MAX_LENGHT = 11;
    const PHONE_MIN_LENGHT = 9;
    const WWW_MAX_LENGHT = 40;
    const MAIL_MAX_LENGHT = 40;
    const NOTE_MAX_LENGHT = 1000;
    const ERROR = '!Zla_Dana!';

    const SAVE_STATUS_OK = 1;
    const SAVE_STATUS_ERROR_DB = -1;

    public function __construct() {
        // tymczasowo dopisywanie aktualnego timestampa do obiektu
//        $teraz = new DateTime();
        $this->date =  new DateTime();
        $this->date = $this->date->format(DATE_ATOM);
    }

    public function __set($parm_name, $parm_value) {
        // jezeli nie ma wartosci ustaw domyslnie null
        if (!$parm_value || $parm_value=='') {
            $this->$parm_name = null;
        }

        // jezeli bledne dane dla parametrow ustaw null
        switch($parm_name) {
            case 'name':
                if (strlen($parm_value) > self::NAME_MAX_LENGHT) {
                    $this->name = null;
                }
                else {
                    $this->$parm_name = $parm_value;
                }
                break;

            case 'idTax':
                if (strlen($parm_value) > self::IDTAX_LENGHT) {
                    $this->idTax = self::ERROR;
                }
                else {
                    $this->$parm_name = $parm_value;
                }
                break;

            case 'address':
                if (strlen($parm_value) > self::ADDRESS_MAX_LENGHT) {
                    $this->address = self::ERROR;
                }
                else {
                    $this->$parm_name = $parm_value;
                }
                break;

            case 'city':
                if (strlen($parm_value) > self::CITY_MAX_LENGHT) {
                    $this->city = null;
                }
                else {
                    $this->$parm_name = $parm_value;
                }
                break;

            case 'phone':
                if(!preg_match('/[0-9]{9,11}/', $parm_value) || strlen($parm_value) > self::PHONE_MAX_LENGHT) {
                    $this->phone = null;
                }
                else {
                    $this->$parm_name = $parm_value;
                }
                break;

            case 'fax':
                if(preg_match('/[0-9]{9,11}/', $parm_value) && strlen($parm_value) <= self::PHONE_MAX_LENGHT) {
                    $this->$parm_name = $parm_value;
                }
                elseif($parm_value=='') {
                    $this->$parm_name = null;
                }
                else {
                    $this->$parm_name = self::ERROR;
                }
                break;

            case 'www':
                if(strlen($parm_value) > self::WWW_MAX_LENGHT) {
                    $this->www = self::ERROR;
                }
                else {
                    $this->$parm_name = $parm_value;
                }
                break;

            case 'mail':
                if(!preg_match('/^([a-z0-9-_.]{1,})@[a-z0-9-]+(.[a-z0-9]{2,})$/i', $parm_value) || strlen($parm_value) > self::MAIL_MAX_LENGHT) {
                    $this->mail = null;
                }
                else {
                    $this->$parm_name = $parm_value;
                }
                break;

            case 'note':
                if (strlen($parm_value) > self::NOTE_MAX_LENGHT) {
                    $this->note = self::ERROR;
                }
                else {
                    $this->$parm_name = $parm_value;
                }
                break;
            default:
                $this->$parm_name = $parm_value;
                break;
        }
    }

    public function __get($parm_name) {
        return $this->$parm_name;
    }

    public function save() {

        //idClient   |  nameClient   |  idTax  |  addressClient  |  cityClient  |  phoneClient  |  faxClient  |  wwwClient  |  mailClient  |  noteClient  | creationDateClient
        $stmt = DBConnection::getConnection()->prepare("INSERT INTO clients (nameClient, idTax, addressClient, cityClient, phoneClient, faxClient, wwwClient, mailClient, noteClient, creationDateClient)
                               VALUES (:nameClient, :tax, :adres, :city, :tel, :fax, :www, :mail, :note, :dateAdd ) ");
        $status = $stmt->execute(
            array(  ':nameClient' => $this->name,
                ':tax' => $this->idTax,
                ':adres' => $this->address,
                ':city' => $this->city,
                ':tel' => $this->phone,
                ':fax' => $this->fax,
                ':www' => $this->www,
                ':mail' => $this->mail,
                ':note' => $this->note,
                ':dateAdd' => $this->date
            )
        );
        if ($status) {
            return self::SAVE_STATUS_OK;
        }
        else {
            return self::SAVE_STATUS_ERROR_DB;
        }
    } // function save()

    protected function checkClient($nameClient) {


    } // function checkClient()
}

