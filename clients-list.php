<?php
require_once __DIR__ . '/includes/classes/DBConnection.php';
include 'includes/header.php';

function listOfClients() {

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
            echo '<td>';

            switch ($columnName) {
                case 'nameClient':
                    echo '<a href="contacts-list.php?id=' . $client['idClient'] . '">' . $columnValue . '</a>';
                    break;
                case 'addressClient':
                    $oneAddress = explode(';',$columnValue);
                    echo $oneAddress[0]. '&nbsp'. $oneAddress[1] . '<br/>' . $oneAddress[2] . '&nbsp' .$client['cityClient'];
                    break;
                case 'cityClient':
                    break;
                case 'wwwClient':
                    if ($columnValue != null) {
                        echo '<a href="http://'.$columnValue.'">link</a>';
                    }
                    break;
                case 'creationDateClient':
                    break;
                default:
                    echo $columnValue;

            }

            echo '</td>';
        }
        echo '</tr>';
    }
}
?>
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
                            <th><!--City--></th>
                            <th>Phone</th>
                            <th>Fax</th>
                            <th>WWW</th>
                            <th>E-mail</th>
                            <th>Note</th>
                            <th><!--Date--></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        listOfClients();
                        ?>
                    </tbody>
                </table>
            </div>
        </article>
    </section>
</div>
<?php include 'includes/footer.php';

?>
