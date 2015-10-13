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

    const STATUS_ARRANGED = 01;
    const STATUS_CONFIRMED = 02;
    const STATUS_COMPLETED = 03;
    const STATUS_CANCELLED = 04;

    const OUTCOME_SUCCESS = 01;
    const OUTCOME_FAILURE = 02;
    const OUTCOME_FOLLOWUP = 03;

    public function __construct($idClient, $dateEvent, $timeEvent, $descriptionEvent, $statusEvent, $idContact="") {
        $this->_getDataForNewEvent($idClient, $dateEvent, $timeEvent, $descriptionEvent, $statusEvent, $idContact="");
        print_r($this);

        $this->persist();
    }

    protected function _getDataForNewEvent($idClient, $dateEvent, $timeEvent, $descriptionEvent, $statusEvent, $idContact=""){
        $this-> idClient = $idClient;
        $this-> date = $dateEvent;
        $this-> time = $timeEvent;
        $this-> description = $descriptionEvent;
        $this-> status = $statusEvent;
    }

    public function persist() {
        try { $pdo = new PDO('mysql:dbname=infoshareaca_5;host=sql.infoshareaca.nazwa.pl', 'infoshareaca_5', 'F0r3v3r!');
        $stmt = $pdo->prepare("INSERT INTO events (idClient,
                                                   dateEvent,
                                                   timeEvent,
                                                   placeEvent,
                                                   typeEvent,
                                                   statusEvent,
                                                   outcomeEvent,
                                                   descriptionEvent) VALUES (
                                                                      :idClient,
                                                                      :dateEvent,
                                                                      :timeEvent,
                                                                      :placeEvent,
                                                                      :typeEvent,
                                                                      :statusEvent,
                                                                      :outcomeEvent,
                                                                      :descriptionEvent
                             );"
        );

        $costam = array(
            ':idClient' => $this->idClient,
            ':dateEvent' => $this->date,
            ':timeEvent' => $this->time,
            ':placeEvent' => "null",
            ':typeEvent' => "null",
            ':statusEvent' => $this->status,
            ':outcomeEvent' => "null",
            ':descriptionEvent' => $this->description
        );
        var_dump($costam);

         echo $stmt->execute(array(
                    ':idClient' => $this->idClient,
                    ':dateEvent' => $this->date,
                    ':timeEvent' => $this->time,
                    ':placeEvent' => "null",
                    ':typeEvent' => "null",
                    ':statusEvent' => $this->status,
                    ':outcomeEvent' => "null",
                    ':descriptionEvent' => $this->description
                )
            );

            $stmt->debugDumpParams();

            $stmt2 = $pdo->prepare("SELECT * FROM events");
            $stmt2->execute();
            echo count($stmt2->fetchAll());
        } catch(Exception $e) {
            print_r($e->getMessage());
        }
    }

    private function getAttributeNames() {
        return array('idClient', 'idContact', 'dateEvent', 'timeEvent', 'statusEvent', 'descriptionEvent');
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
    public $typeEvent = "meeting";

//    public
//
//    protected function _getDataForNewMeeting(){
//
//    }

//    public function persist(){
//        parent::persist()
//    }
}

class Call extends Event {
    protected $phoneNumber;
    protected $duration;
    public $typeEvent = "call";

//    public function setPhoneNUmber ($phoneNumber = "") {
//       In this function we need to design how to get the phone number if we have it already in the DB
//    }
}

class VideoConference extends Event {
    protected $number;
    protected $duration;
    protected $skypeUser;
    public $typeEvent = "video conference";
}

class Email extends Event {
    protected $emailAddress;
    public $typeEvent = "email";
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
    $typeOfEvent = $_POST['typeOfEvent'];

    $descriptionEvent = htmlspecialchars($descriptionEvent);
    print_r( $_POST);}

if ($idClient!="" &&
    $dateEvent!="" &&
    $timeEvent!="" &&
    $descriptionEvent!="" &&
    $statusEvent!="" &&
    $typeOfEvent!="") {
    switch ($typeOfEvent) {
        case 01:
            new Call($idClient, $dateEvent, $timeEvent, $descriptionEvent, $statusEvent);
            echo "new Call";
            break;
        case 02:
            new Email($idClient, $dateEvent, $timeEvent, $descriptionEvent, $statusEvent);
            echo "new Email";
            break;
        case 03:
            new VideoConference($idClient, $dateEvent, $timeEvent, $descriptionEvent, $statusEvent);
            echo "new Video conf";
            break;
        case 04:
            new Meeting($idClient, $dateEvent, $timeEvent, $descriptionEvent, $statusEvent);
            echo "new Meeting";
            break;
        default:
            echo "Please select \'type of event\'";
    }
//    $newEvent = new Event($idClient, $dateEvent, $timeEvent, $descriptionEvent, $statusEvent, $idContact="");

} else {
    echo "Please fill out all the required fields";
}



echo "</pre>";
?>

<!--generating the list of Client/Contact remember to put ID as value and NAME as label in the form-->

<form action="?" method="post">
    Client:
    <select name="idClient">
        <option value="1" <?php if (@$idClient=='1') echo 'selected'; ?>>Coca-Cola</option>
        <option value="2" <?php if (@$idClient=='2') echo 'selected'; ?>>Firma Bardzo Wazna i Fajna</option>
        <option value="3" <?php if (@$idClient=='3') echo 'selected'; ?>>Spolka jakas bardzo tajna z o.o.</option>
        <option value="4" <?php if (@$idClient=='4') echo 'selected'; ?>>Dell Inc.</option>
        <option value="5" <?php if (@$idClient=='5') echo 'selected'; ?>>Default</option>
        <option value="6" <?php if (@$idClient=='6') echo 'selected'; ?>>Olivia Business Center</option>
        <option value="7" <?php if (@$idClient=='7') echo 'selected'; ?>>Szama mniam mniam</option>
        <option value="8" <?php if (@$idClient=='8') echo 'selected'; ?>>Video Inc.</option>
    </select><br/><br/>

    *Contact:
    <select name="idContact">
        <option value="1" <?php if (@$idContact=='1') echo 'selected'; ?>>Anna Nowak</option>
        <option value="2" <?php if (@$idContact=='2') echo 'selected'; ?>>Bob Smith</option>
        <option value="3" <?php if (@$idContact=='3') echo 'selected'; ?>>Adam Cnoweel</option>
        <option value="4" <?php if (@$idContact=='4') echo 'selected'; ?>>Wojtek Kowalski</option>
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
        <option value="03" <?php if (@$statusEvent=='03') echo 'selected'; ?>>completed</option>
        <option value="04" <?php if (@$statusEvent=='04') echo 'selected'; ?>>cancelled</option>
    </select><br/><br/>

    Type of event:
    <select name="typeOfEvent">
        <option value="01" <?php if (@$typeOfEvent=='01') echo 'selected'; ?>>Call</option>
        <option value="02" <?php if (@$typeOfEvent=='02') echo 'selected'; ?>>Email</option>
        <option value="03" <?php if (@$typeOfEvent=='03') echo 'selected'; ?>>Video conference</option>
        <option value="04" <?php if (@$typeOfEvent=='04') echo 'selected'; ?>>Meeting</option>
    </select><br/><br/>

    <input type="submit" name="submitNewEvent" value="Submit" />
</form>
