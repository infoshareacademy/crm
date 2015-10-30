<?php
include 'includes/header.php';

require_once __DIR__ . '/includes/classes/Client.php';

$error = array();

$blad = '!Zla_Dana!'; // wartosc ta sama co w stalej klasy ERROR - alez to dramatyczne rozwiazanie; zajme sie tym pozniej
// przejecie danych z posta
if (count($_POST)) {
    $client = new Client();

    //pola wymagane
    $client->name = @$_POST['name'];
    if(!$client->name)
        $error['name'] = 'Name is required';

    $client->city = @$_POST['city'];
    if(!$client->city)
        $error['city'] = 'City is required';

    $client->phone = (int)@$_POST['phone'];
    if(!$client->phone)
        $error['phone'] = 'Phone is required (9-11 numbers)';

    $client->mail = @$_POST['mail'];
    if(!$client->mail)
        $error['mail'] = 'Mail address is required (ex. mail@domain.com)';

    // nieobowiazkowe
    $client->idTax = @$_POST['idTax'];
    if($client->idTax === $blad)
        $error['idTax'] = 'Max lenght 11 numbers';

    // zebranie danych z trzech pol formularza i spreparowanie ich tak jak sa przechowywane w db
    // street ; streetNumber ; postcode
    if(@$_POST['street'] || @$_POST['streetNumber'] || @$_POST['postCode']) {
        $tableAddress = array (htmlspecialchars(@$_POST['street']),htmlspecialchars(@$_POST['streetNumber']),htmlspecialchars(@$_POST['postCode']));
        $address = implode(";", $tableAddress);
        $client->address = $address;
    }
    else {
        $client->address = null;
    }

    if($client->address === $blad)
        $error['address'] = 'Max length 255';

    $client->fax = @$_POST['fax'];
    if($client->fax === $blad)
        $error['fax'] = 'Required 9-11 numbers';

    $client->www = @$_POST['www'];
    if($client->www === $blad)
        $error['www'] = 'Max lenght 40 characters';

    $client->note = @$_POST['note'];
    if($client->note === $blad)
        $error['note'] = 'Max length 100 characters';

    //zapis
    if(count($error) == 0) {
        $status = $client->save();
        if($status == Client::SAVE_STATUS_OK) {
            header("Location: clients-list.php");
        }
        else {
            $error['global'] = 'Fatally! I can\' save this Client!';
        }
    }

} // end of if(count($_POST))


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
                    if (@$error['general'])
                    echo '<div class="text-uppercase text-danger">'.$error['general'].'</div><br/>';
                ?>

                <form action="?" method="post"><br />
                    Required:<br/>
                    Client name *: <input name="name" value='<?php echo @$_POST["name"]?>'><br/><div class='small text-uppercase text-danger'><?php echo @$error['name']?></div>
                    City (HQ) *: <input name="city" value="<?php echo @$_POST['city']?>" /><br/><div class='small text-uppercase text-danger'><?php echo @$error['city']?></div>
                    Phone *: <input name="phone" value="<?php echo @$_POST['phone']?>" /><br/><div class='small text-uppercase text-danger'><?php echo @$error['phone']?></div>
                    e-mail *: <input name="mail" value="<?php echo @$_POST['mail']?>" /><br/><div class='small text-uppercase text-danger'><?php echo @$error['mail']?></div>
                    <br/>
                    Additional details:<br/>
                    Tax Id: <input name="idTax" value="<?php echo @$_POST['idTax']?>" /><br/><div class='small text-uppercase text-danger'><?php echo @$error['idTax']?></div>
                    Street: <input name="street" value="<?php echo @$_POST['street']?>" /> No: <input name="streetNumber" size="6" value="<?php echo @$_POST['streetNumber']?>" /> Post Code: <input name="postCode" size="10" value="<?php echo @$_POST['postCode']?>" /><br/><div class='small text-uppercase text-danger'><?php echo @$error['address']?></div>
                    fax: <input name="fax" value="<?php echo @$_POST['fax']?>" /><br/><div class='small text-uppercase text-danger'><?php echo @$error['fax']?></div>
                    www: <input name="www" value="<?php echo @$_POST['www']?>" /><br/><div class='small text-uppercase text-danger'><?php echo @$error['www']?></div>

                    Note: <textarea name="note" rows="4" cols="50" /><?php echo @$_POST['note']?></textarea><div class='small text-uppercase text-danger'><?php echo @$error['note']?></div>
                    <button id="btn_send">ADD THIS</button>
                </form>

            </div>
        </article>
    </section>

</div>
<?php include 'includes/footer.php';
?>