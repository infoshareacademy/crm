<?php
include 'includes/header.php'; include 'includes/classes/OverallEventsReportDisplay.php';
?>
<div role="tabpanel" id="generate-report">

    <section class="container-fluid">
        <figure class="banner">
            <figcaption>Generate report</figcaption>
        </figure>
<?php
$displayer = new OverallEventsReportDisplay();
echo $displayer->display();
?>
    </section>
</div>

<?php
include 'includes/footer.php';
?>