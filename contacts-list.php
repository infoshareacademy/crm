<?php include 'includes/header.php'; ?>
<div role="tabpanel" id="plan-event">

    <section class="container-fluid">
        <figure class="banner">
            <figcaption>Contacts from Client</figcaption>
        </figure>

        <article class="row">
            <div class="col-lg-12">
                <h1></h1>
<?php

//create query
// surnameContact, nameContact, positionContact, phoneContact, emailContact, cityContact linkedinContact, noteContact
if (isset($_GET['id'])) {
    $getId = (int)$_GET['id'];
    $sql = 'SELECT surnameContact, nameContact, positionContact, phoneContact, emailContact, cityContact, linkedinContact, noteContact FROM contacts WHERE idClient='.$getId;
}
else {
    $sql = "";
}

if ($sql) {
// execute query
try {
    $contacts = DBConnection::getConnection()->query($sql);
    $clients = $contacts->fetchAll(PDO::FETCH_ASSOC);
}
catch (Exception $e) {
    $clients = array();
}
} else {
    $clients = array();
}


//each client has own table; display only cells with content
foreach ($clients as $clientId=>$client) {
    echo '<address><table>';
    foreach ($client as $attributeValue) {
        if ($attributeValue != '')
            echo '<tr><td>'.$attributeValue.' </td></tr>';
    }
    echo '</table></address><br /><br />';
}

// if client without contacts
if (count($clients) == 0)
    echo "That's a shame! This client hasn't contact";

?>
                <div><a href="clients-list">Back to Clients list</a></div>
            </div>
        </article>
    </section>

</div>
<?php include 'includes/footer.php'; ?>
