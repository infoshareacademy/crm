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
Please indicate the main Client for the Event. Contact person can be added later.

                <form class="form-horizontal" action="?" method="post">
                    <input type="hidden" name="idOfEvent" value="<?php echo @$event->idOfEvent ?>"/>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="idClient">Client:</label>
                        <div class="col-xs-12 col-sm-9 col-md-7">
                            <select class="form-control" name="idClient" id="idClient">
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
                        </div>
                        <div style="color: #23527c"><?php echo @$error['idClient'] ?></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3" for="idContact">*Contact:</label>
                        <div class="col-xs-12 col-sm-9 col-md-7">
                            <select class="form-control" name="idContact" id="idContact">

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
                    </div>
                    <div class="form-group">
                        <label for="topicOfEvent" class="col-sm-3 control-label">Topic:</label>
                        <div class="col-xs-12 col-sm-9 col-md-7">
                            <input type="text" class="form-control" name="topicOfEvent" id="topicOfEvent"><?php echo @$event->topicOfEvent ?></input>
                        </div>
                        <div style="color: #23527c"><?php echo @$error['topicOfEvent'] ?></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="descriptionOfEvent">Description:</label>
                        <div class="col-xs-12 col-sm-9 col-md-7">
                            <input type="text" class="form-control" id="descriptionOfEvent" name="descriptionOfEvent"><?php echo @$event->descriptionOfEvent ?></input>
                        </div>
                        <div style="color: #23527c"><?php echo @$error['descriptionOfEvent'] ?></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="dateOfEvent">Date:</label>
                        <div class="col-xs-12 col-sm-9 col-md-7">
                            <input class="form-control" type="date" name="dateOfEvent" id="dateOfEvent" value="<?php echo @$event->dateOfEvent ?>" />
                        </div>
                        <div style="color: #23527c"><?php echo @$error['dateOfEvent'] ?></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="timeOfEvent">Time:</label>
                        <div class="col-xs-12 col-sm-9 col-md-7">
                            <input class="form-control" type="time" name="timeOfEvent" id="timeOfEvent" value="<?php echo @$event->timeOfEvent ?>" />
                        </div>
                        <div style="color: #23527c"><?php echo @$error['timeOfEvent'] ?></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="statusOfEvent">Status:</label>
                        <div class="col-xs-12 col-sm-9 col-md-7">
                            <select class="form-control" name="statusOfEvent" id="statusOfEvent">
                                <option value="01" <?php if (@$event->statusOfEvent==Event::EVENT_ARRANGED) echo 'selected'; ?>>Arranged</option>
                                <option value="02" <?php if (@$event->statusOfEvent==Event::EVENT_CONFIRMED) echo 'selected'; ?>>Confirmed</option>
                                <option value="03" <?php if (@$event->statusOfEvent==Event::EVENT_COMPLETED) echo 'selected'; ?>>Completed</option>
                                <option value="04" <?php if (@$event->statusOfEvent==Event::EVENT_CANCELLED) echo 'selected'; ?>>Cancelled</option>
                            </select>
                        </div>
                        <div style="color: #23527c"><?php echo @$error['statusOfEvent'] ?></div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="typeOfEvent">Type of event:</label>
                        <div class="col-xs-12 col-sm-9 col-md-7">
                            <select class="form-control" name="typeOfEvent">
                                <option value="01" <?php if (@$event->typeOfEvent==Event::EVENT_TYPE_CALL) echo 'selected'; ?>>Call</option>
                                <option value="02" <?php if (@$event->typeOfEvent==Event::EVENT_TYPE_EMAIL) echo 'selected'; ?>>Email</option>
                                <option value="03" <?php if (@$event->typeOfEvent==Event::EVENT_TYPE_VIDEO) echo 'selected'; ?>>Video conference</option>
                                <option value="04" <?php if (@$event->typeOfEvent==Event::EVENT_TYPE_MEETING) echo 'selected'; ?>>Meeting</option>
                            </select>
                        </div>
                        <div style="color: #23527c"><?php echo @$error['typeOfEvent'] ?></div>
                    </div>

                    <input type="submit" class="btn btn-primary col-sm-offset-7" name="submitNewEvent" value="Submit" />
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
