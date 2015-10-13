<?php

class Event {

// basic attributes of newly created Event:

    protected $topicOfEvent;
    protected $idClient;
    protected $dateOfEvent;
    protected $timeOfEvent;
    protected $statusOfEvent;
    protected $descriptionOfEvent;
    protected $typeOfEvent;

// additional (not required) attributes of newly created Event:

    protected $idContact; // if the counterpart's representative is indicated


// other attributes added to the Event when updated/closed:

    protected $idOfEvent; // will be set based on return from DB //
    protected $outcomeOfEvent; // Event is closed - the result for reporting purpose

// constant values for the methods of this class in the human friendly notation

    const STATUS_ARRANGED = 01;
    const STATUS_CONFIRMED = 02;
    const STATUS_COMPLETED = 03;
    const STATUS_CANCELLED = 04;

    const OUTCOME_SUCCESS = 01;
    const OUTCOME_FAILURE = 02;
    const OUTCOME_FOLLOWUP = 03;

// methods of Event class:

    public function __construct($topicOfEvent,
                                $idClient,
                                $dateOfEvent,
                                $timeOfEvent,
                                $statusOfEvent,
                                $typeOfEvent,
                                $descriptionOfEvent) {
        $this->topicOfEvent = $topicOfEvent;
        $this->idClient = $idClient;
        $this->dateOfEvent = $dateOfEvent;
        $this->timeOfEvent = $timeOfEvent;
        $this->statusOfEvent = $statusOfEvent;
        $this->typeOfEvent = $typeOfEvent;
        $this->descriptionOfEvent = $descriptionOfEvent;

    }

    // function collecting data from $_POST submitted via the Event Form ??
//
//    protected function _getDataForNewEvent(){
//
//    }

    // function connecting to the DB and inserting the values from Object

    protected function _sendEventDataToDB(){
        try {
            $pdo = new PDO('mysql:dbname=infoshareaca_5;host=sql.infoshareaca.nazwa.pl', 'infoshareaca_5', 'F0r3v3r!');
            $stmt = $pdo->prepare("INSERT INTO events (idClient,
                                                       dateEvent,
                                                       timeEvent,
                                                       typeEvent,
                                                       statusEvent,
                                                       descriptionEvent,
                                                       topicEvent) VALUES (
                                                                      :idClient,
                                                                      :dateOfEvent,
                                                                      :timeOfEvent,
                                                                      :typeOfEvent,
                                                                      :statusOfEvent,
                                                                      :descriptionOfEvent,
                                                                      :topicOfEvent
                             );"
            );

            $stmt->execute(array(
                    ':idClient' => $this->idClient,
                    ':dateEvent' => $this->dateOfEvent,
                    ':timeEvent' => $this->timeOfEvent,
                    ':typeEvent' => $this->typeOfEvent,
                    ':statusEvent' => $this->statusOfEvent,
                    ':descriptionEvent' => $this->descriptionOfEvent,
                    ':topicOfEvent' => $this->topicOfEvent
                )
            );

//            $stmt->debugDumpParams();
//
//            $stmt2 = $pdo->prepare("SELECT * FROM events");
//            $stmt2->execute();
//            echo count($stmt2->fetchAll());
        } catch(Exception $e) {
            print_r($e->getMessage());
        }
    }



}

// save input from the form in the variable if some info is missing when form is submitted

if (count($_POST)) {
    $topicOfEvent = $_POST['topicOfEvent'];
    $idClient = $_POST['idClient'];
    $dateOfEvent = $_POST['dateOfEvent'];
    $timeOfEvent = $_POST['timeOfEvent'];
    $statusOfEvent = $_POST['statusOfEvent'];
    $typeOfEvent = $_POST['typeOfEvent'];
    $descriptionOfEvent = $_POST['descriptionOfEvent'];

    $topicOfEvent = htmlspecialchars($topicOfEvent);
    $descriptionOfEvent = htmlspecialchars($descriptionOfEvent);
}

// trigger for creation of new Event when all the required info in the form

if ($topicOfEvent!="" &&
    $idClient!="" &&
    $dateOfEvent!="" &&
    $timeOfEvent!="" &&
    $statusOfEvent!="" &&
    $typeOfEvent!="" &&
    $descriptionOfEvent!="") {

    $newEvent = new Event($topicOfEvent,
                          $idClient,
                          $dateOfEvent,
                          $timeOfEvent,
                          $statusOfEvent,
                          $typeOfEvent,
                          $descriptionOfEvent);

} else {
    echo 'Please insert the missing information';
}

?>

ADD NEW EVENT:

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

    Topic:
    <textarea name="topicOfEvent"><?php echo @$topicOfEvent ?></textarea><br/><br/>
    Description:
    <textarea name="descriptionOfEvent"><?php echo @$descriptionOfEvent ?></textarea><br/><br/>

    Date:
    <input type="date" name="dateOfEvent" value="<?php echo @$dateOfEvent ?>" /><br/><br/>
    Time:
    <input type="time" name="timeOfEvent" value="<?php echo @$timeOfEvent ?>" /><br/><br/>
    Status:
    <select name="statusOfEvent">
        <option value="01" <?php if (@$statusOfEvent=='01') echo 'selected'; ?>>Arranged</option>
        <option value="02" <?php if (@$statusOfEvent=='02') echo 'selected'; ?>>Confirmed</option>
        <option value="03" <?php if (@$statusOfEvent=='03') echo 'selected'; ?>>Completed</option>
        <option value="04" <?php if (@$statusOfEvent=='04') echo 'selected'; ?>>Cancelled</option>
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

