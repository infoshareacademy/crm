<?php include 'includes/header.php';
require_once('includes/class/ContactDAO.php');
require_once('includes/class/ContactClass.php');
include "includes/class/vCard.php";


if (isset($_GET['delete'])) {
    $contactDao = Contact::createEmpty();
    $contactDao->setId($_GET['delete']);
    $contactDao->delete();
    $newContact = Contact::createEmpty();
}

$contact = [];

function createClient ($param_pathToVcf) {
    if (file_exists($param_pathToVcf)) {
        $result = file_get_contents($param_pathToVcf);
        $newVCard = new VCard();
        $contact = $newVCard->extract($result);
        return $contact;
    }
}

function upload_file($file_field) {
    $user_filename = $file_field['name'];
    $extension = substr($user_filename, strrpos($user_filename, '.')+1, 5);
    $pathToCards = 'C:\Dev\crm\crm\vcards'. '\\';
    do {
        $hash = uniqid(rand(0, 99999));
        $server_filename = $hash . '.' . $extension;
    } while (file_exists($pathToCards . $server_filename));

// kopiowanie pliku z katalogu tymczasowego do naszego projektu podkatalogu TEST

    $status = move_uploaded_file($file_field['tmp_name'], $pathToCards . $server_filename);
    $pathToVcf = $pathToCards . $server_filename;


    if ($status)
        return $pathToVcf;
    else
        return 'BLAD';
}

if (count($_FILES)) {
    $VCFpath = upload_file($_FILES['upload']);
    $contact = createClient($VCFpath);

        $newContact = new Contact(
            $contact['surname'],
            $contact['name'],
            $contact['position'],
            $contact['phone'],
            $contact['email'],
            $contact['city'],
            ' ', ' '
        );
        $error = $newContact->isValid();

        $newContact->persist();

}

?>
<div role="tabpanel" id="events-list">

        <section class="container-fluid">
            <figure class="banner">
                <figcaption>Contacts</figcaption>
            </figure>




            <article class="row">
                <div class="col-lg-12">



                    <table  class="table table-hover table-condensed">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Surname</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Phone</th>
                            <th>Mail</th>
                            <th>City</th>
                            <th>LinkedIn</th>
                            <th>Note</th>
                            <th>OPTIONS</th>
                        </tr>
                        </thead>



                        <?php

                        $list = Contact::getList();
                        foreach ($list as $item) {
                            echo '<tr>';
                            echo '<td>' . $item['idContact'] . '</td>';
                            echo '<td>' . $item['surnameContact'] . '</td>';
                            echo '<td>' . $item['nameContact'] . '</td>';
                            echo '<td>' . $item['positionContact'] . '</td>';
                            echo '<td>' . $item['phoneContact'] . '</td>';
                            echo '<td>' . $item['emailContact'] . '</td>';
                            echo '<td>' . $item['cityContact'] . '</td>';
                            echo '<td>' . $item['linkedinContact'] . '</td>';
                            echo '<td>' . $item['noteContact'] . '</td>';
                            echo '<td><a href="contacts-disp.php?contactid=' . $item['idContact'] . '">EDIT</a> <a href="contacts-disp.php?delete=' . $item['idContact'] . '">DELETE</a></td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                        echo '<br/><br/>';
                        ?>

                </div>
            </article>
        </section>

</div>
<?php include 'includes/footer.php'; ?>