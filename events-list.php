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
        die ('Oups, there is no such Event ! Please verify with the Administrator.');
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

?>
<div role="tabpanel" id="clients-list">
    <section class="container-fluid">
        <figure class="banner">
            <figcaption>Events list</figcaption>
        </figure>
        <article class="row">
            <div class="col-lg-12">

                <div style="color: #23527c"><?php echo @$success ?></div>

                <p>Please see below the list of upcoming
                    events along with the Events from last 3 days.</p>
                <br>
                <br>
                <table  class="table table-hover table-condensed">
                    <thead>
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
                    </thead>

                    <tbody>

                    <?php
                        $allEvents = Event::displayFromEvents('list');

                        foreach ($allEvents as $item) {
                            echo '<tr>';
                            echo '<td>'.$item['nameClient'].'</td>';
                            echo '<td>'.$item['dateOfEvent'].'</td>';
                            echo '<td>'.$item['timeOfEvent'].'</td>';
                            echo '<td>'.EventsPresenter::translateStatusOfEvent($item['statusOfEvent']).'</td>';
                            echo '<td>'.EventsPresenter::translateTypeOfEvent($item['typeOfEvent']).'</td>';
                            echo '<td>'.$item['topicOfEvent'].'</td>';
                            echo '<td>'.$item['descriptionOfEvent'].'</td>';
                            echo '<td>'.EventsPresenter::translateOutcomeOfEvent($item['outcomeOfEvent']).'</td>';
                            echo '<td>';
                            if (User::getUser()->permissions >= User::USER_USER) {
                                echo '<a href="edit-event.php?edit='.$item['idOfEvent'].'">Edit</a>';
                            }
                            if (User::getUser()->permissions == User::USER_ADMIN) {
                                echo '<a href = "?delete='.$item['idOfEvent'].'" > Delete</a >';
                            }
                            echo '</td>';
                            echo '</tr>';
                        }
                    ?>

                    </tbody>
                </table>
<hr/>
            </div>
        </article>
    </section>

</div>
<?php
include 'includes/footer.php';

?>
