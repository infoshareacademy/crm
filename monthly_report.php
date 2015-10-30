<?php

include 'includes/header.php';
require_once __DIR__ . '/includes/classes/ClientEventsReportPresenter.php';
require_once __DIR__ . '/includes/classes/Event.php';
?>
    <div role="tabpanel" id="generate-report" xmlns="http://www.w3.org/1999/html">

        <section class="container-fluid">
            <figure class="banner">
                <figcaption>Generate report</figcaption>
            </figure>
            <div>
                In order to generate a monthly report please choose the Client from the list:</br>
                <form action="?" method="get">
                    <select name="idClient">
                    <?php
                $listOfClients = Event::displayFromEvents('Client');
                    foreach ($listOfClients as $item) {
                    echo "<option value='" .
                        $item['idClient'].
                        "'" . ($item['idClient'] == $_GET['idClient'] ? 'selected' : '') . ">" .
                        $item['nameClient'] .
                        "</option>";
                }
                ?>
                    </select>
                    <input type="submit" name="submitNewEvent" value="Generate" />
                    </form>
            </div>

            <?php
            if (@$_GET['idClient'] && (int)$_GET['idClient']) {
                $idClient = $_GET['idClient'];
                $displayer = new ClientEventsReportPresenter();
                echo $displayer->display($idClient);
            }
            ?>
        </section>
    </div>

<?php
include 'includes/footer.php';
?>