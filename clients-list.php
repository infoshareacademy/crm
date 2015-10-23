<?php
include 'includes/header.php'; ?>
<div role="tabpanel" id="clients-list">
    <section class="container-fluid">
        <figure class="banner">
            <figcaption>Clients list</figcaption>
        </figure>
        <article class="row">
            <div class="col-lg-12">

                <table  class="table table-hover table-condensed">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Company</th>
                        <th>Tax ID</th>
                        <th>Adress</th>
                        <th>City</th>
                        <th>Phone</th>
                        <th>Fax</th>
                        <th>WWW</th>
                        <th>E-mail</th>
                        <th>Note</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>
<?php

//    struktura tabeli
//    idClient   |  nameClient   |  idTax  |  addressClient
//  |  cityClient  |  phoneClient  |  faxClient  |  wwwClient
//  |  mailClient  |  noteClient  | creationDateClient

    $sql = "SELECT * FROM clients";
    $clients = DBConnection::getConnection()->query($sql);
    $clients = $clients->fetchAll(PDO::FETCH_ASSOC);

    // wyswietlanie wynikow
    foreach ($clients as $client) {
        echo '<tr>';
        foreach ($client as $columnName => $columnValue) {
            if ($columnName == 'nameClient')
            echo '<td><a href="contacts-list.php?id=' . $client['idClient'] . '">' . $columnValue . '</a></td>';
            else echo '<td>' . $columnValue . '</td>';
        }
        echo '</tr>';
    }
?>
                    </tbody>
                </table>
            </div>
        </article>
    </section>
</div>
<?php include 'includes/footer.php';

?>
