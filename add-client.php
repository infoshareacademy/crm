<?php include 'includes/header.php';  include_once "includes/class/client.class.php"?>
<div role="tabpanel" id="add-client">

    <section class="container-fluid">
        <figure class="banner">
            <figcaption>Add client</figcaption>
        </figure>

        <article class="row">
            <div class="col-lg-12">
                <h1> </h1>

                <form action="?" method="post">
                    Client name: <input name="name" value="<?php @$_POST['name']?>"/><br/><div style="color:#f00;"><?php @$error['name']?></div>
                    Tax Id: <input name="idTax" value="<?php @$_POST['idTax']?>" /><br/><div style="color:#f00;"><?php @$error['idTax']?></div>
                    Adres: <input name="address" value="<?php @$_POST['address']?>" /><br/>[street;number;post code]<div style="color:#f00;"><?php @$error['address']?></div>
                    City: <input name="city" value="<?php @$_POST['city']?>" /><br/><div style="color:#f00;"><?php @$error['city']?></div>
                    Phone: <input name="phone" value="<?php @$_POST['phone']?>" /><br/><div style="color:#f00;"><?php @$error['phone']?></div>
                    fax: <input name="fax" value="<?php @@$_POST['fax']?>" /><br/><div style="color:#f00;"><?php @$error['fax']?></div>
                    www: <input name="www" value="<?php @$_POST['www']?>" /><br/><div style="color:#f00;"><?php @$error['www']?></div>
                    e-mail: <input name="mail" value="<?php @$_POST['mail']?>" /><br/><div style="color:#f00;"><?php @$error['mail']?></div>
                    Note: <textarea name="note" /><?php @$_POST['note']?></textarea><div style="color:#f00;"><?php @$error['note']?></div>
                    <button id="btn_send">ADD THIS</button>
                    </form>

            </div>
        </article>
    </section>

</div>
<?php include 'includes/footer.php'; ?>