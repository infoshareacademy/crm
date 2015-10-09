<?php
//
//$hostname = "sql.infoshareaca.nazwa.pl";
//$db = "infoshareaca_5";
//$username = "infoshareaca_5";
//$pass = "F0r3v3r!";
//
//
//$dbh = new PDO ("mysql:host=$hostname;port=3307;dbname=$db",$username,$pass);
//$dbh->query("SET NAMES utf8");
//$dbh->query("SET CHARACTER_SET utf8_polish_ci");
//
//$sql = "SELECT * FROM events";
//
//$events = $dbh->query($sql);


class Event {
    protected $id;
    protected $idClient;
    protected $idContact;
    protected $date;
    protected $time;
    protected $status;
    protected $outcome;
    protected $description;
    protected $status_change_comment = array();

    const STATUS_ARRANGED = 1;
    const STATUS_CONFIRMED = 2;
    const STATUS_COMPLETED = 3;
    const STATUS_CANCELLED = 4;

    public function __construct($idClient, $date, $time, $Contact="") {
        $this-> idClient = $idClient;
        $this-> date = $date;
        $this-> time = $time;
    }

    public function changeStatus ($new_status) {
        $statusName = "";
        switch ($new_status) {
            case self::STATUS_ARRANGED:
                $statusName = "arranged";
                break;
            case self::STATUS_CONFIRMED:
                $statusName = "confirmed";
                break;
            case self::STATUS_COMPLETED:
                $statusName = "completed";
                break;
            case self::STATUS_CANCELLED:
                $statusName = "cancelled";
                break;
            default:
                $statusName = "changed";
        }
            $this->status_change_comment[] = "Event has been ".$statusName.'.';
    }

    public function changeType () {

//        this function should:
//        1. create a new Object of the chosen class (Meeting/Call/Email/VideoConference)
//        2. copy the value of all the relevant attributes
//        3. destruct the redundant Object

    }
}

class Meeting extends Event {
    protected $place;
    protected $duration;
}

class Call extends Event {
    protected $phoneNumber;
    protected $duration;

//    public function setPhoneNUmber ($phoneNumber = "") {
//       In this function we need to design how to get the phone number if we have it already in the DB
//    }
}

class VideoConference extends Event {
    protected $number;
    protected $duration;
    protected $skypeUser;
}

class Email extends Event {
    protected $emailAddress;
}


class eventManager {
//    private function
}