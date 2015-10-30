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

if (isset($_GET['contactid'])) {
    $contactDao = new ContactDAO();
    $newContact = $contactDao->loadContact($_GET['contactid']);
} else if (count($_POST)) {
    $newContact = loadDataFromPost();
    $error = $newContact->isValid();
} else if (isset($_GET['delete'])) {
    $contactDao = Contact::createEmpty();
    $contactDao->setId($_GET['delete']);
    $contactDao->delete();
    $newContact = Contact::createEmpty();
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

                    <form class="form-horizontal" action="?" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                        <label for="surname" class="col-sm-2 control-label">Surname</label>
                            <div class="col-sm-8"><input class="form-control" name="surname" id="surname" value="<?php echo @$newContact->surname() ?>"/><br/>
                        <div style="color:#f00;"><?php echo @$error['surname']; ?></div></div></div>

                            <div class="form-group">
                        Name: <input class="form-control" name="name" value="<?php echo @$newContact->name() ?>"/><br/>
                        <div style="color:#f00;"><?php echo @$error['name']; ?></div></div>
                                <div class="form-group">
                        Position: <input  class="form-control" name="position" value="<?php echo $newContact->position() ?>"/><br/>
                        <div style="color:#f00;"><?php echo @$error['position']; ?></div></div>
                                    <div class="form-group">
                        Phone: <input class="form-control" name="phone" value="<?php echo @$newContact->phone() ?>"/><br/>
                        <div style="color:#f00;"><?php echo @$error['phone']; ?></div></div>
                                        <div class="form-group">
                        E-mail: <input class="form-control" name="email" value="<?php echo @$newContact->email() ?>"/><br/>
                        <div style="color:#f00;"><?php echo @$error['email']; ?></div></div>
                                            <div class="form-group">
                        City: <input class="form-control" name="city" value="<?php echo @$newContact->city() ?>"/><br/>
                        <div style="color:#f00;"><?php echo @$error['city']; ?></div></div>
                                                <div class="form-group">
                        LinkedIn: <input class="form-control" name="linkedin" value="<?php echo @$newContact->linkedin() ?>"/><br/>
                        <div style="color:#f00;"><?php echo @$error['linkedin']; ?></div></div>
                                                    <div class="form-group">
                        Note:<textarea class="form-control" name="note"><?php echo @$newContact->note() ?></textarea><br/>
                        <input class="form-control" type="hidden" name="id" value="<?php echo @$newContact->id() ?>"></div>

                                                        <div class="form-group">
                        <input class="btn btn-info" type="submit" name="send" value="SEND"/>
                                                        </div>
                    </form>


                    <hr>
                    <form action="add-new-contact.php?" method="post" enctype="multipart/form-data">
                        Upload vCard:<input type="file" name="upload" value=""/><br/>
                        <input type="submit" name="send" value="send" />
                    </form>
                    <hr>


                    <br/>


                    <a href="?">CLEAN FORM</a>
                    <br/>
                    <br/>

                </div>
            </article>
        </section>

    </div>
<?php  include 'includes/footer.php';
    ?>