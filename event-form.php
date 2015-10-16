<?php
require_once 'Event.class.php';

function displayStatusOfEvent($statusOfEvent){
    switch ($statusOfEvent){
        case Event::EVENT_ARRANGED:
            return "Arranged";
        case Event::EVENT_CONFIRMED:
            return "Confirmed";
        case Event::EVENT_COMPLETED:
            return "Completed";
        case Event::EVENT_CANCELLED:
            return "Cancelled";
        default:
            return "--missing status--";
    }
}

function displayTypeOfEvent($typeOfEvent){
    switch ($typeOfEvent){
        case Event::EVENT_TYPE_CALL:
            return "Call";
        case Event::EVENT_TYPE_EMAIL:
            return "Email";
        case Event::EVENT_TYPE_MEETING:
            return "Meeting";
        case Event::EVENT_TYPE_VIDEO:
            return "Video conference";
        default:
            return "--missing type--";
    }
}

function displayOutcomeOfEvent($outcomeOfEvent){
    switch ($outcomeOfEvent){
        case Event::OUTCOME_SUCCESS:
            return "success";
        case Event::OUTCOME_FOLLOWUP:
            return "follow up";
        case Event::OUTCOME_FAILURE:
            return "failure";
        default:
            return "--missing outcome--";
    }
}

// Function triggered when 'Edit' button at the list of Events is clicked

if (@$_GET['edit'] && (int)$_GET['edit']) {
    $edit = $_GET['edit'];
    print_r($_GET);

    try {
        $event = new Event($edit);
    }
    catch (Exception $e) {
        echo 'Oups, there is no such Event ! Please verify with the Administrator.';
    }
}

// Function triggered when 'Delete' button at the list of Events is clicked

if (@$_GET['delete'] && (int)$_GET['delete']) {
    $delete = (int)$_GET['delete'];

    try {
        $event = new Event($delete);
        $status = $event->deleteEvent();
        if ($status)
            $success = 'Event deleted';
        else
            $error['general'] = 'An error occurred, please try again later or contact your Admin.';
    }
    catch (Exception $e) {
        die('Oups, there is no such Event ! Please verify with the Administrator.');
    }
}

$error = array();
if (count($_POST)) {

//    1. create new, empty Event
    echo '<br><br><pre>post:';
    print_r($_POST);
    echo '<br><br></pre>';
    $event = new Event();

//    2. fill it out with info from the form

    $event->idOfEvent = $_POST['idOfEvent'];

    $event->topicOfEvent = @$_POST['topicOfEvent'];
    if (!$event->topicOfEvent)
        $error['topicOfEvent'] = 'Please insert the topic of this Event
        (up to 50 characters)';

    $event->idClient = $_POST['idClient'];
    if (!$event->idClient)
        $error['idClient'] = 'Please indicate the Client';

    $event->idContact = $_POST['idContact'];

    $event->dateOfEvent = $_POST['dateOfEvent'];
    if (!$event->dateOfEvent)
        $error['dateOfEvent'] = 'Please insert the date';

    $event->timeOfEvent = $_POST['timeOfEvent'];
    if (!$event->timeOfEvent)
        $error['timeOfEvent'] = 'Please insert the time';

    $event->statusOfEvent = $_POST['statusOfEvent'];
    if (!$event->statusOfEvent)
        $error['statusOfEvent'] = 'Please indicate the status of this Event';

    $event->typeOfEvent = $_POST['typeOfEvent'];
    if (!$event->typeOfEvent)
        $error['typeOfEvent'] = 'Please chose the type of Event';

    $event->descriptionOfEvent = $_POST['descriptionOfEvent'];
    if (!$event->descriptionOfEvent)
        $error['descriptionOfEvent'] =
            'Please insert a short description of this Event (up to 250 characters)';

    $event->outcomeOfEvent = @$_POST['outcomeOfEvent'];

    echo '<br><br><pre>Event from DB';
    print_r($event);
    echo '<br><br></pre>';

// 3. insert the data to DB

    if (!count($error)){
        $event->sendToDB();
        echo "<br/><br/><br/><br/><br/><br/>YUPI<br/><br/><br/><br/><br/>";
        echo $event->idOfEvent;
        echo '<br><br><pre>Event from DB';
        print_r($event);
        echo '<br><br></pre>';
    }
}
?>

ADD NEW EVENT:

<form action="?" method="post">
    <input type="hidden" name="idOfEvent" value="<?= @$event->idOfEvent ?>"/>
    Client:
    <select name="idClient">

        <?php
        $listOfClients = Event::displayFromEvents('Client');
        foreach ($listOfClients as $item) {

        echo "<option value='" .
            $item['idClient'].
            "' " . ($event->idClient == $item['idClient'] ? 'selected' : '') . ">" .
            $item['nameClient'] .
            "</option>";
        }
        ?>

   </select>
    <div style="color: #23527c"><?php echo @$error['idClient'] ?></div>
    <br/><br/>

    *Contact:
    <select name="idContact">

        <?php
        $listOfContacts = Event::displayFromEvents('Contact');
        foreach ($listOfContacts as $item) {

            echo "<option value='" .
                $item['idContact'].
                "' " . ($event->idContact == $item['idContact'] ? 'selected' : '') . ">" .
                $item['nameContact'] ." " . $item['surnameContact'] .
                "</option>";
        }
        ?>

    </select>

    <br/><br/>

    Topic:
    <textarea name="topicOfEvent"><?php echo @$event->topicOfEvent ?></textarea>
    <div style="color: #23527c"><?php echo @$error['topicOfEvent'] ?></div>
    <br/><br/>
    Description:
    <textarea name="descriptionOfEvent"><?php echo @$event->descriptionOfEvent ?></textarea>
    <div style="color: #23527c"><?php echo @$error['descriptionOfEvent'] ?></div>
    <br/><br/>

    Date:
    <input type="date" name="dateOfEvent" value="<?php echo @$event->dateOfEvent ?>" />
    <div style="color: #23527c"><?php echo @$error['dateOfEvent'] ?></div>
    <br/><br/>
    Time:
    <input type="time" name="timeOfEvent" value="<?php echo @$event->timeOfEvent ?>" />
    <div style="color: #23527c"><?php echo @$error['timeOfEvent'] ?></div>
    <br/><br/>
    Status:
    <select name="statusOfEvent">
        <option value="01" <?php if (@$event->statusOfEvent==Event::EVENT_ARRANGED) echo 'selected'; ?>>Arranged</option>
        <option value="02" <?php if (@$event->statusOfEvent==Event::EVENT_CONFIRMED) echo 'selected'; ?>>Confirmed</option>
        <option value="03" <?php if (@$event->statusOfEvent==Event::EVENT_COMPLETED) echo 'selected'; ?>>Completed</option>
        <option value="04" <?php if (@$event->statusOfEvent==Event::EVENT_CANCELLED) echo 'selected'; ?>>Cancelled</option>
    </select>
    <div style="color: #23527c"><?php echo @$error['statusOfEvent'] ?></div>
    <br/><br/>

    Type of event:
    <select name="typeOfEvent">
        <option value="01" <?php if (@$event->typeOfEvent==Event::EVENT_TYPE_CALL) echo 'selected'; ?>>Call</option>
        <option value="02" <?php if (@$event->typeOfEvent==Event::EVENT_TYPE_EMAIL) echo 'selected'; ?>>Email</option>
        <option value="03" <?php if (@$event->typeOfEvent==Event::EVENT_TYPE_VIDEO) echo 'selected'; ?>>Video conference</option>
        <option value="04" <?php if (@$event->typeOfEvent==Event::EVENT_TYPE_MEETING) echo 'selected'; ?>>Meeting</option>
    </select>
    <div style="color: #23527c"><?php echo @$error['typeOfEvent'] ?></div>
    <br/><br/>

    <input type="submit" name="submitNewEvent" value="Submit" />
    <br/><br/>
    <a type="button" href="?">Clear the form</a><br/>


    LIST OF UPCOMING EVENTS:

<table>
    <tr>
        <th>Client</th>
        <th>Date</th>
        <th>Time</th>
        <th>Status</th>
        <th>Type</th>
        <th>Topic</th>
        <th>Description</th>
        <th>Outcome</th>
    </tr>
    <?php
    $allEvents = Event::displayFromEvents('list');
    foreach ($allEvents as $item) {
        echo '<tr>';
        echo '<td>'.$item['nameClient'].'</td>';
        echo '<td>'.$item['dateOfEvent'].'</td>';
        echo '<td>'.$item['timeOfEvent'].'</td>';
        echo '<td>'.displayStatusOfEvent($item['statusOfEvent']).'</td>';
        echo '<td>'.displayTypeOfEvent($item['typeOfEvent']).'</td>';
        echo '<td>'.$item['topicOfEvent'].'</td>';
        echo '<td>'.$item['descriptionOfEvent'].'</td>';
        echo '<td>'.displayOutcomeOfEvent($item['outcomeOfEvent']).'</td>';
        echo '<td><a href="?edit='.$item['idOfEvent'].'">Edit</a>
        <a href="?delete='.$item['idOfEvent'].'">Delete</a></td>';
    echo '</tr>';
    }
    ?>
</table>

</form>

