<?php

include 'includes/header.php';

require_once __DIR__ . '/includes/classes/ContactDAO.php';
require_once __DIR__ . '/includes/classes/Contact.php';
require_once __DIR__ . '/includes/classes/vCard.php';
/**
 * Created by PhpStorm.
 * User: paoolskoolsky
 * Date: 09.10.15
 * Time: 16:27
 */

function createClient ($param_pathToVcf) {
    if (file_exists($param_pathToVcf)) {
        $result = file_get_contents($param_pathToVcf);
        unlink($param_pathToVcf);
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

function loadDataFromFile()
{
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
    if (!count($error)) {
        $newContact->persist();

    }
    return $newContact;

}

function loadDataFromPost()
{
    $newContact = new Contact(
        $_POST['surname'],
        $_POST['name'],
        $_POST['position'],
        $_POST['phone'],
        $_POST['email'],
        $_POST['city'],
        $_POST['linkedin'],
        $_POST['note']
    );
    if (isset($_POST['id'])) {
        $newContact->setId($_POST['id']);
    }
    $error = $newContact->isValid();
    if (!count($error)) {
        $newContact->persist();

    }
    return $newContact;


}

if (count($_FILES)) {
    $newContact = loadDataFromFile();
    $error = $newContact->isValid();
} else if (count($_POST)) {
    $newContact = loadDataFromPost();
    $error = $newContact->isValid();
} else {
    $newContact = Contact::createEmpty();
}



?>


    <div role="tabpanel" id="events-list">

        <section class="container-fluid">
            <figure class="banner">
                <figcaption>Contacts</figcaption>
            </figure>





            <article class="row">
                <div class="col-lg-12">
                <?php    if (count($_POST)) {
                    $error = $newContact->isValid();
                    if (!count($error) && !(@$_GET['contactid'])) {
                    echo '<div style="color:#22aa22; font-weight:bold;">Success - new item in DB!</div><br/>';

                    $newContact = Contact::createEmpty();
                    }
                    }
                ?>

<hr>
<form class="form-inline" action="?" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="vcard">Upload vCard:</label>
        <input type="file" name="upload" id="vcard" value=""/>
    </div>
    <input type="submit" class="btn btn-primary" name="send" value="Send" />
</form>
<hr>


<br/>
<?php if (count($_FILES) || count($_POST)) { ?>
    <form class="form-horizontal" action="?" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="surname" class="col-sm-2 control-label">Surname</label>

            <div class="col-sm-8">
                <input class="form-control" name="surname" id="surname"
                       value="<?php echo @$newContact->surname() ?>"/><br/>

                <div style="color:#f00;"><?php echo @$error['surname']; ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Name</label>

            <div class="col-sm-8">
                <input class="form-control" name="name" id="name"
                       value="<?php echo @$newContact->name() ?>"/><br/>

                <div style="color:#f00;">
                    <?php echo @$error['name']; ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="position" class="col-sm-2 control-label">Position</label>

            <div class="col-sm-8">
                <input class="form-control" name="position" id="position"
                       value="<?php echo $newContact->position() ?>"/><br/>

                <div style="color:#f00;">
                    <?php echo @$error['position']; ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="phone" class="col-sm-2 control-label">Phone</label>

            <div class="col-sm-8">
                <input class="form-control" name="phone" id="phone"
                       value="<?php echo @$newContact->phone() ?>"/><br/>

                <div style="color:#f00;">
                    <?php echo @$error['phone']; ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="E-mail" class="col-sm-2 control-label">E-mail</label>

            <div class="col-sm-8">
                <input class="form-control" name="email" id="E-mail"
                       value="<?php echo @$newContact->email() ?>"/><br/>

                <div style="color:#f00;">
                    <?php echo @$error['email']; ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="City" class="col-sm-2 control-label">City</label>

            <div class="col-sm-8">
                <input class="form-control" name="city" id="City"
                       value="<?php echo @$newContact->city() ?>"/><br/>

                <div style="color:#f00;">
                    <?php echo @$error['city']; ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="LinkedIn" class="col-sm-2 control-label">LinkedIn</label>

            <div class="col-sm-8">
                <input class="form-control" name="linkedin" id="LinkedIn"
                       value="<?php echo @$newContact->linkedin() ?>"/><br/>

                <div style="color:#f00;">
                    <?php echo @$error['linkedin']; ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="Note" class="col-sm-2 control-label">Note</label>

            <div class="col-sm-8"><textarea class="form-control" name="note"
                                            id="Note"><?php echo @$newContact->note() ?></textarea><br/>
                <input class="form-control" type="hidden" name="id"
                       value="<?php echo @$newContact->id() ?>"></div>
        </div>


        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-8"><input class="btn btn-primary" type="submit" name="send"
                                                         value="SEND"/>
            </div>
    </form>

<?php } ?>



                    <a href="?">CLEAN FORM</a>
                    <br/>
                    <br/>

                </div>
            </article>
        </section>

    </div>
<?php  include 'includes/footer.php';
    ?>