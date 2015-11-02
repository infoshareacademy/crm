<?php
include 'includes/header.php';
require_once __DIR__ . '/includes/classes/Event.php';
require_once __DIR__ . '/includes/classes/EventsPresenter.php';

if (@$_GET['edit'] && (int)$_GET['edit']) {
    $edit = $_GET['edit'];

    try {
        $event = new Event($edit);
    }
    catch (Exception $e) {
        echo 'Oups, there is no such Event ! Please verify with the Administrator.';
    }
}

if (@$_GET['delete'] && (int)$_GET['delete']) {
    $delete = (int)$_GET['delete'];

    try {
        $event = new Event($delete);
        $status = $event->deleteEvent();
        if ($status) {
            $success = 'Event deleted';
        } else {
            $error['general'] = 'An error occurred, please try again later or contact your Admin.';
        }
    }
    catch (Exception $e) {
        die('Oups, there is no such Event ! Please verify with the Administrator.');
    }
}

$error = array();
if (count($_POST)) {

    $event = new Event();

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

    if (!count($error)){
        $event->sendToDB();
        $success = 'Cool! Event has been sent to DB';
    }
}
?>
<div role="tabpanel" id="clients-list">
    <section class="container-fluid">
        <figure class="banner">
            <figcaption>Plan new event</figcaption>
        </figure>
        <article class="row">
            <div class="col-lg-12">


<div style="color: #23527c"><?php echo @$success ?></div>

                Please remember to indicate the major Client for the Event, this field is required.<br/>
                If you don't know who's the Contact for this particular Event, that's fine - you can come back later with more details.
<br/><br/>
<div class="container">
<form role="form" class="form-horizontal" action="?" method="post">
        <input type="hidden" name="idOfEvent" value="<?php echo @$event->idOfEvent ?>"/>

    <div class="form-group">
        <label class="control-label col-xs-2" for="idClient">Client:</label>
        <select class="form-control col-xs-offset-2 col-xs-5" name="idClient" id="idClient">
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
    </div>

    <div class="form-group">
        <label class="control-label col-xs-2" for="idContact">*Contact:</label>
        <select class="form-control col-xs-offset-2 col-xs-5" name="idContact" id="idContact">

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
    </div>
    <div class="form-group">
        <label for="topicOfEvent" class="control-label">Topic:</label>
        <textarea class="form-control" name="topicOfEvent" id="topicOfEvent"><?php echo @$event->topicOfEvent ?></textarea>
        <div style="color: #23527c"><?php echo @$error['topicOfEvent'] ?></div>
    </div>
    <div class="form-group">
        <label class="control-label" for="descriptionOfEvent">Description:</label>
        <textarea class="form-control" id="descriptionOfEvent" name="descriptionOfEvent"><?php echo @$event->descriptionOfEvent ?></textarea>
        <div style="color: #23527c"><?php echo @$error['descriptionOfEvent'] ?></div>
    </div>
    <div class="form-group">
        <label class="control-label" for="dateOfEvent">Date:</label>
        <input class="form-control" type="date" name="dateOfEvent" id="dateOfEvent" value="<?php echo @$event->dateOfEvent ?>" />
        <div style="color: #23527c"><?php echo @$error['dateOfEvent'] ?></div>
    </div>
    <div class="form-group">
        <label class="control-label" for="timeOfEvent">Time:</label>
        <input class="form-control" type="time" name="timeOfEvent" id="timeOfEvent" value="<?php echo @$event->timeOfEvent ?>" />
        <div style="color: #23527c"><?php echo @$error['timeOfEvent'] ?></div>
    </div>
    <div class="form-group">
        <label class="control-label" for="statusOfEvent">Status:</label>
        <select class="form-control" name="statusOfEvent" id="statusOfEvent">
            <option value="01" <?php if (@$event->statusOfEvent==Event::EVENT_ARRANGED) echo 'selected'; ?>>Arranged</option>
            <option value="02" <?php if (@$event->statusOfEvent==Event::EVENT_CONFIRMED) echo 'selected'; ?>>Confirmed</option>
            <option value="03" <?php if (@$event->statusOfEvent==Event::EVENT_COMPLETED) echo 'selected'; ?>>Completed</option>
            <option value="04" <?php if (@$event->statusOfEvent==Event::EVENT_CANCELLED) echo 'selected'; ?>>Cancelled</option>
        </select>
        <div style="color: #23527c"><?php echo @$error['statusOfEvent'] ?></div>
    </div>
    <div class="form-group">
        <label class="control-label" for="typeOfEvent">Type of event:</label>
        <select class="form-control" name="typeOfEvent">
            <option value="01" <?php if (@$event->typeOfEvent==Event::EVENT_TYPE_CALL) echo 'selected'; ?>>Call</option>
            <option value="02" <?php if (@$event->typeOfEvent==Event::EVENT_TYPE_EMAIL) echo 'selected'; ?>>Email</option>
            <option value="03" <?php if (@$event->typeOfEvent==Event::EVENT_TYPE_VIDEO) echo 'selected'; ?>>Video conference</option>
            <option value="04" <?php if (@$event->typeOfEvent==Event::EVENT_TYPE_MEETING) echo 'selected'; ?>>Meeting</option>
        </select>
        <div style="color: #23527c"><?php echo @$error['typeOfEvent'] ?></div>
    </div>

    <input type="submit" class="btn btn-primary" name="submitNewEvent" value="Submit" />
    <a type="button" class="btn btn-default" href="?">Clear the form</a><br/>
</form>
</div>





            </div>
        </article>
    </section>

</div>
<?php
include 'includes/footer.php';

?>
