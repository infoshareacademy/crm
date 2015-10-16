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
    const ADDRESS_MAX_LENGHT = 80;
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
        $teraz = new DateTime();
        $this->date = $teraz->getTimestamp();
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
        $pdo = new PDO('mysql:dbname=infoshareaca_5;host=test.crm.infoshareaca.nazwa.pl', 'infoshareaca_5', 'F0r3v3r!');
        //idClient   |  nameClient   |  idTax  |  addressClient  |  cityClient  |  phoneClient  |  faxClient  |  wwwClient  |  mailClient  |  noteClient  | creationDateClient
        $stmt = $pdo->prepare("INSERT INTO clients (nameClient, idTax, addressClient, cityClient, phoneClient, faxClient, wwwClient, mailClient, noteClient, creationDateClient)
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
    }
}


$error = array();

$blad = '!Zla_Dana!'; // wartosc ta sama co w stalej klasy ERROR - alez to dramatyczne rozwiazanie; zajme sie tym pozniej
// przejecie danych z posta
if (count($_POST)) {
    $client = new Client();

    //pola wymagane
    $client->name = @$_POST['name'];
    if(!$client->name)
        $error['name'] = 'Podaj nazwe kontrahenta';

    $client->city = @$_POST['city'];
    if(!$client->city)
        $error['city'] = 'Wpisz miasto';

    $client->phone = (int)@$_POST['phone'];
    if(!$client->phone)
        $error['phone'] = 'Numer musi skladac sie z 9-11  cyfr';

    $client->mail = @$_POST['mail'];
    if(!$client->mail)
        $error['mail'] = 'Podaj prawidlowy mail z @ i poprawna domena';

    // nieobowiazkowe
    $client->idTax = @$_POST['idTax'];
    if($client->idTax === $blad)
        $error['idTax'] = 'Tax ID moze miec max 11 cyfr';

    $client->address = @$_POST['address'];
    if($client->address === $blad)
        $error['address'] = 'Max 80 znakow';

    $client->fax = @$_POST['fax'];
    if($client->fax === $blad)
        $error['fax'] = 'Numer musi skladac sie z 9-11  cyfr';

    $client->www = @$_POST['www'];
    if($client->www === $blad)
        $error['www'] = 'Domena do 40 znakow';

    $client->note = @$_POST['note'];
    if($client->note === $blad)
        $error['note'] = 'to ma byc krotka notatka do 100 znakow ;)';

    //zapis
    if(count($error) == 0) {
        //echo 'Proba zapisu<br/><br/><br/>';
        $status = $client->save();
        if($status == Client::SAVE_STATUS_OK) {
            $success = "Qrde udalo sie";
        }
        else {
            $error['global'] = 'Fatalnie nie da rady zapisac tego Clienta';
        }
    }

} // end of if(count($_POST))


?>
