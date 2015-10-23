<?php
include 'includes/header.php';
require_once __DIR__ . '/includes/classes/client.class.php';
?>
<div role="tabpanel" id="add-client">

    <section class="container-fluid">
        <figure class="banner">
            <figcaption>Add client</figcaption>
        </figure>

        <article class="row">
            <div class="col-lg-12">
                <h1> </h1>

                <?php
                    if (@$success)
                    echo '<div style="color:#22aa22; font-weight:bold;">'.$success.'</div><br/>';

                    if (@$error['general'])
                    echo '<div style="color:#f00; font-weight:bold;">'.$error['general'].'</div><br/>';
                ?>

                <form action="?" method="post">
                    Client name: <input name="name" value='<?php echo @$_POST["name"]?>'><br/><div style="color:#f00;"><?php echo @$error['name']?></div>
                    Tax Id: <input name="idTax" value="<?php echo @$_POST['idTax']?>" /><br/><div style="color:#f00;"><?php echo @$error['idTax']?></div>
                    Street: <input name="street" value="<?php echo @$_POST['street']?>" /> No: <input name="streetNumber" size="6" value="<?php echo @$_POST['streetNumber']?>" />Post Code: <input name="postCode" size="10" value="<?php echo @$_POST['postCode']?>" /><br/><div style="color:#f00;"><?php echo @$error['address']?></div>
                    City: <input name="city" value="<?php echo @$_POST['city']?>" /><br/><div style="color:#f00;"><?php echo @$error['city']?></div>
                    Phone: <input name="phone" value="<?php echo @$_POST['phone']?>" /><br/><div style="color:#f00;"><?php echo @$error['phone']?></div>
                    fax: <input name="fax" value="<?php echo @$_POST['fax']?>" /><br/><div style="color:#f00;"><?php echo @$error['fax']?></div>
                    www: <input name="www" value="<?php echo @$_POST['www']?>" /><br/><div style="color:#f00;"><?php echo @$error['www']?></div>
                    e-mail: <input name="mail" value="<?php echo @$_POST['mail']?>" /><br/><div style="color:#f00;"><?php echo @$error['mail']?></div>
                    Note: <textarea name="note" /><?php echo @$_POST['note']?></textarea><div style="color:#f00;"><?php echo @$error['note']?></div>
                    <button id="btn_send">ADD THIS</button>
                </form>

            </div>
        </article>
    </section>

</div>
<?php include 'includes/footer.php';
?>