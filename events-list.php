<?php include 'includes/header.php';
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
            return "missing type";
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
            return "missing outcome";
    }
}
?>
    <div role="tabpanel" id="events-list">

    <section class="container-fluid">
        <figure class="banner">
            <figcaption>Events list</figcaption>
        </figure>

        <article class="row">
            <div class="col-lg-12">
                <p>Please see below the list of upcoming events along with the Events from last 3 days.</p>
            </div>
        </article>
    </section>

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
                echo '<td><a href="plan-event.php?edit='.$item['idOfEvent'].'">Edit</a>
        <a href="plan-event.php?delete='.$item['idOfEvent'].'">Delete</a></td>';
                echo '</tr>';
            }
            ?>
        </table>

</div>
<?php include 'includes/footer.php'; ?>