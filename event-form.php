<?php
require_once 'Event.class.php';

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
        <option value="1" <?php if (@$event->idContact=='1') echo 'selected'; ?>>Anna Nowak</option>
        <option value="2" <?php if (@$event->idContact=='2') echo 'selected'; ?>>Bob Smith</option>
        <option value="3" <?php if (@$event->idContact=='3') echo 'selected'; ?>>Adam Cnoweel</option>
        <option value="4" <?php if (@$event->idContact=='4') echo 'selected'; ?>>Wojtek Kowalski</option>
    </select><br/><br/>

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
        <option value="01" <?php if (@$event->statusOfEvent=='01') echo 'selected'; ?>>Arranged</option>
        <option value="02" <?php if (@$event->statusOfEvent=='02') echo 'selected'; ?>>Confirmed</option>
        <option value="03" <?php if (@$event->statusOfEvent=='03') echo 'selected'; ?>>Completed</option>
        <option value="04" <?php if (@$event->statusOfEvent=='04') echo 'selected'; ?>>Cancelled</option>
    </select>
    <div style="color: #23527c"><?php echo @$error['statusOfEvent'] ?></div>
    <br/><br/>

    Type of event:
    <select name="typeOfEvent">
        <option value="01" <?php if (@$event->typeOfEvent=='01') echo 'selected'; ?>>Call</option>
        <option value="02" <?php if (@$event->typeOfEvent=='02') echo 'selected'; ?>>Email</option>
        <option value="03" <?php if (@$event->typeOfEvent=='03') echo 'selected'; ?>>Video conference</option>
        <option value="04" <?php if (@$event->typeOfEvent=='04') echo 'selected'; ?>>Meeting</option>
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
    $list = "list";
    $allEvents = array();
    $allEvents = Event::displayFromEvents($list);
    foreach ($allEvents as $item) {
        echo '<tr>';
        echo '<td>'.$item['idClient'].'</td>';
        echo '<td>'.$item['dateOfEvent'].'</td>';
        echo '<td>'.$item['timeOfEvent'].'</td>';
        echo '<td>'.$item['statusOfEvent'].'</td>';
        echo '<td>'.$item['typeOfEvent'].'</td>';
        echo '<td>'.$item['topicOfEvent'].'</td>';
        echo '<td>'.$item['descriptionOfEvent'].'</td>';
        echo '<td>'.$item['outcomeOfEvent'].'</td>';
        echo '<td><a href="?edit='.$item['idOfEvent'].'">Edit</a>
        <a href="?delete='.$item['idOfEvent'].'">Delete</a></td>';
    echo '</tr>';
    }
    ?>
</table>

</form>

