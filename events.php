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

    const OUTCOME_SUCCESS = 1;
    const OUTCOME_FAILURE = 2;
    const OUTCOME_FOLLOWUP = 3;

    public function __construct($idClient, $dateEvent, $timeEvent, $descriptionEvent, $statusEvent, $idContact) {
        $this-> idClient = $idClient;
        $this-> date = $dateEvent;
        $this-> time = $timeEvent;
        $this-> descriptionEvent = $descriptionEvent;
        $this-> statusEvent = $statusEvent;
        $this-> idContact = $idContact;
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
echo "<pre>";

if (count($_POST)) {
    $idClient = $_POST['idClient'];
    $idContact = $_POST['idContact'];
    $dateEvent = $_POST['dateEvent'];
    $timeEvent = $_POST['timeEvent'];
    $descriptionEvent = $_POST['descriptionEvent'];
    $statusEvent = $_POST['statusEvent'];

    $descriptionEvent = htmlspecialchars($descriptionEvent);
    print_r( $_POST);}
echo "</pre>";
?>

<!--generating the list of Client/Contact remember to put ID as value and NAME as label in the form-->

<form action="?" method="post">
    Client:
    <select name="idClient">
        <option value="01" <?php if (@$idClient=='01') echo 'selected'; ?>>label 1</option>
        <option value="02" <?php if (@$idClient=='02') echo 'selected'; ?>>label 2</option>
    </select><br/><br/>

    *Contact:
    <select name="idContact">
        <option value="01" <?php if (@$idContact=='01') echo 'selected'; ?>>label 1</option>
        <option value="02" <?php if (@$idContact=='02') echo 'selected'; ?>>label 2</option>
    </select><br/><br/>

    Date:
    <input type="date" name="dateEvent" value="<?php echo @$dateEvent ?>" /><br/><br/>
    Time:
    <input type="time" name="timeEvent" value="<?php echo @$timeEvent ?>" /><br/><br/>
    Description:
    <textarea name="descriptionEvent"><?php echo @$descriptionEvent ?></textarea><br/><br/>
    Status:
    <select name="statusEvent">
        <option value="01" <?php if (@$statusEvent=='01') echo 'selected'; ?>>arranged</option>
        <option value="02" <?php if (@$statusEvent=='02') echo 'selected'; ?>>confirmed</option>
        <option value="03" <?php if (@$statusEvent=='03') echo 'selected'; ?>>complited</option>
        <option value="04" <?php if (@$statusEvent=='04') echo 'selected'; ?>>cancelled</option>
    </select><br/><br/>

    <input type="submit" name="submitNewEvent" value="Submit" />
</form>
