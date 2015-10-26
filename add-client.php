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
        $error['name'] = 'Podaj nazwe kontrahenta';

    $client->city = @$_POST['city'];
    if(!$client->city)
        $error['city'] = 'Wpisz miasto';

    $client->phone = (int)@$_POST['phone'];
    if(!$client->phone)
        $error['phone'] = 'Numer musi skladac sie z 9-11  cyfr';

    $client->mail = @$_POST['mail'];
    if(!$client->mail)
        $error['mail'] = 'Podaj prawidlowy mail z @ i poprawna domena';

    // nieobowiazkowe
    $client->idTax = @$_POST['idTax'];
    if($client->idTax === $blad)
        $error['idTax'] = 'Tax ID moze miec max 11 cyfr';

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
        $error['address'] = 'Max 255 znakow';

    $client->fax = @$_POST['fax'];
    if($client->fax === $blad)
        $error['fax'] = 'Numer musi skladac sie z 9-11  cyfr';

    $client->www = @$_POST['www'];
    if($client->www === $blad)
        $error['www'] = 'Domena do 40 znakow';

    $client->note = @$_POST['note'];
    if($client->note === $blad)
        $error['note'] = 'to ma byc krotka notatka do 100 znakow ;)';

    //zapis
    if(count($error) == 0) {
        //echo 'Proba zapisu<br/><br/><br/>';
        $status = $client->save();
        if($status == Client::SAVE_STATUS_OK) {
            $success = "Qrde udalo sie";
        }
        else {
            $error['global'] = 'Fatalnie nie da rady zapisac tego Clienta';
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