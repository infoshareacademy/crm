<?php

include 'includes/header.php';

require_once __DIR__ . '/includes/classes/ContactDAO.php';
require_once __DIR__ . '/includes/classes/Contact.php';
require_once __DIR__ . '/includes/classes/vCard.php';

require_once __DIR__ . '/includes/functions/contactForm.php';


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
    $pathToCards = 'vcards/';
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
                    <?php echo contactForm($newContact, $error); ?>
                </div>
            </article>
        </section>

</div>
<?php include 'includes/footer.php'; ?>