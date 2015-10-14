<?php
require_once 'Event.class.php';


// save input from the form in the variable if some info is missing when form is submitted

$error = array();
if (count($_POST)) {
    $event = new Event();

    $event->topicOfEvent = @$_POST['topicOfEvent']; echo 'topic of event set!';
    if (!$event->topicOfEvent)
        $error['topicOfEvent'] = 'Please insert the topic of this Event';

    $event->idClient = $_POST['idClient']; echo 'Client of event set!';
    if (!$event->idClient)
        $error['idClient'] = 'Please indicate the Client';

    $event->dateOfEvent = $_POST['dateOfEvent']; echo 'date of event set!';
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

    $event->descriptionOfEvent = $_POST['descriptionOfEvent']; echo 'description of event set!';
    if (!$event->descriptionOfEvent)
        $error['descriptionOfEvent'] = 'Please insert the short description of this Event';

    echo "<pre>";
    print_r( $_POST);
    echo "<br/><br/><br/>";
    print_r( $event);
    echo "</pre>";
}

// trigger for creation of new Event when all the required info in the form

//if ($topicOfEvent!="" &&
//    $idClient!="" &&
//    $dateOfEvent!="" &&
//    $timeOfEvent!="" &&
//    $statusOfEvent!="" &&
//    $typeOfEvent!="" &&
//    $descriptionOfEvent!="") {
//
//    $newEvent = new Event($topicOfEvent,
//                          $idClient,
//                          $dateOfEvent,
//                          $timeOfEvent,
//                          $statusOfEvent,
//                          $typeOfEvent,
//                          $descriptionOfEvent);
//    $newEvent->_sendEventDataToDB();
//    echo "<pre>";
//    print_r($newEvent);
//    echo "</pre><br/><br/>";
//
//} else {
//    echo 'Please insert the missing information <br/><br/>';
//}

?>

ADD NEW EVENT:

<form action="?" method="post">
    Client:
    <select name="idClient">
        <option value="1" <?php if (@$event->idClient=='1') echo 'selected'; ?>>Coca-Cola</option>
        <option value="2" <?php if (@$event->idClient=='2') echo 'selected'; ?>>Firma Bardzo Wazna i Fajna</option>
        <option value="3" <?php if (@$event->idClient=='3') echo 'selected'; ?>>Spolka jakas bardzo tajna z o.o.</option>
        <option value="4" <?php if (@$event->idClient=='4') echo 'selected'; ?>>Dell Inc.</option>
        <option value="5" <?php if (@$event->idClient=='5') echo 'selected'; ?>>Default</option>
        <option value="6" <?php if (@$event->idClient=='6') echo 'selected'; ?>>Olivia Business Center</option>
        <option value="7" <?php if (@$event->idClient=='7') echo 'selected'; ?>>Szama mniam mniam</option>
        <option value="8" <?php if (@$event->idClient=='8') echo 'selected'; ?>>Video Inc.</option>
    </select>
    <div style="color: #23527c"><?php echo @$error['idClient'] ?></div>
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
</form>

