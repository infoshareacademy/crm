<?php

include 'includes/header.php';

require_once __DIR__ . '/includes/classes/ContactDAO.php';
require_once __DIR__ . '/includes/classes/ContactClass.php';
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


if (count($_POST)) {
    $error = $newContact->isValid();
    if (!count($error) && !(@$_GET['contactid'])) {
        echo '<div style="color:#22aa22; font-weight:bold;">Success - new item in DB!</div><br/>';

        $newContact = Contact::createEmpty();
    }
}

?>


    <div role="tabpanel" id="events-list">

        <section class="container-fluid">
            <figure class="banner">
                <figcaption>Contacts</figcaption>
            </figure>




            <article class="row">
                <div class="col-lg-12">


                    <form action="?" method="post" enctype="multipart/form-data">

                        Surname: <input name="surname" value="<?php echo @$newContact->surname() ?>"/><br/>

                        <div style="color:#f00;"><?php echo @$error['surname']; ?></div>
                        Name: <input name="name" value="<?php echo @$newContact->name() ?>"/><br/>

                        <div style="color:#f00;"><?php echo @$error['name']; ?></div>
                        Position: <input name="position" value="<?php echo $newContact->position() ?>"/><br/>

                        <div style="color:#f00;"><?php echo @$error['position']; ?></div>
                        Phone: <input name="phone" value="<?php echo @$newContact->phone() ?>"/><br/>

                        <div style="color:#f00;"><?php echo @$error['phone']; ?></div>
                        E-mail: <input name="email" value="<?php echo @$newContact->email() ?>"/><br/>

                        <div style="color:#f00;"><?php echo @$error['email']; ?></div>
                        City: <input name="city" value="<?php echo @$newContact->city() ?>"/><br/>

                        <div style="color:#f00;"><?php echo @$error['city']; ?></div>
                        LinkedIn: <input name="linkedin" value="<?php echo @$newContact->linkedin() ?>"/><br/>

                        <div style="color:#f00;"><?php echo @$error['linkedin']; ?></div>
                        Note:<textarea name="note"><?php echo @$newContact->note() ?></textarea><br/>
                        <input type="hidden" name="id" value="<?php echo @$newContact->id() ?>">


                        <input type="submit" name="send" value="SEND"/>
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
                        echo '<td><a href="?contactid=' . $item['idContact'] . '">EDIT</a> <a href="?delete=' . $item['idContact'] . '">DELETE</a></td>';
                        echo '</tr>';
                    }
                    echo '</table>';
                    echo '<br/><br/>';
                    ?>

                </div>
            </article>
        </section>

    </div>
<?php  include 'includes/footer.php';
    ?>