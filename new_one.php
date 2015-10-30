<?php

include 'includes/header.php'; require_once 'includes/classes/ClientEventsReportPresenter.php';
?>
    <div role="tabpanel" id="generate-report">

        <section class="container-fluid">
            <figure class="banner">
                <figcaption>Generate report</figcaption>
            </figure>
            <?php
            $displayer = new ClientEventsReportPresenter();
            echo $displayer->display(1);
            ?>
        </section>
    </div>

<?php
include 'includes/footer.php';
?>