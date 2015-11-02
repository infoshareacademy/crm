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
            header("Location: clients-list");
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
            <figcaption>Add Client</figcaption>
        </figure>

        <article class="row">
            <div class="col-lg-12">
                <h1> </h1>

                <?php
                    if (@$error['general'])
                    echo '<div class="text-uppercase text-danger">'.$error['general'].'</div><br/>';
                ?>

                <form class="form-horizontal" action="?" method="post"><br />
                    <div class="form-group">
                        <label for="Required" class="col-sm-2 control-label">Required:</label>
                    </div>

                        <div class="form-group">
                            <label for="Client name" class="col-sm-2 control-label">Client name*</label>
                            <div class="col-sm-6">
                                <input class="form-control" name="name" id="Client name" value='<?php echo @$_POST["name"]?>'>
                            </div>
                            <div class="col-sm-2">
                                <div class='small text-uppercase text-danger'><?php echo @$error['name']?></div>
                            </div>
                        </div>



                        <div class="form-group">
                            <label for="City HQ" class="col-sm-2 control-label">City HQ*</label>
                            <div class="col-sm-6">
                                <input class="form-control" name="city" id="City HQ" value="<?php echo @$_POST['city']?>" />
                            </div>

                            <div class="col-sm-2">
                                <div class='small text-uppercase text-danger'><?php echo @$error['city']?></div>
                            </div>
                        </div>



                        <div class="form-group">
                            <label for="Phone" class="col-sm-2 control-label">Phone*</label>
                            <div class="col-sm-6">
                                <input class="form-control" name="phone" id="Phone" value="<?php echo @$_POST['phone']?>" />
                            </div>
                                <div class="col-sm-2"><div class='small text-uppercase text-danger'><?php echo @$error['phone']?></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="E-mail" class="col-sm-2 control-label">E-mail*</label>
                            <div class="col-sm-6">
                                <input class="form-control" name="mail" id="E-mail" value="<?php echo @$_POST['mail']?>" />
                            </div>
                            <div class='small text-uppercase text-danger'><?php echo @$error['mail']?></div>
                        </div>

                        <div class="form-group">
                                <label for="Additional details" class="col-sm-2 control-label">Additional details:</label>
                        </div>


                        <div class="form-group">
                            <label for="tax" class="col-sm-2 control-label">Tax Id</label>
                            <div class="col-sm-6">
                                <input class="form-control" name="idTax" value="<?php echo @$_POST['idTax']?>" />
                            </div>
                            <div class='small text-uppercase text-danger'><?php echo @$error['idTax']?></div>
                        </div>




                        <div class="form-group">
                            <label for="streetName" class="col-sm-2 control-label">Street</label>
                            <div class="col-sm-6">
                                <input class="form-control" name="street" value="<?php echo @$_POST['street']?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="streetNumber" class="col-sm-2 control-label">No</label>
                            <div class="col-sm-6">
                                <input class="form-control" name="streetNumber" value="<?php echo @$_POST['streetNumber']?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="codePost" class="col-sm-2 control-label">Post code</label>
                            <div class="col-sm-6">
                                <input class="form-control" name="postCode" value="<?php echo @$_POST['postCode']?>" />
                            </div>
                            <div class='small text-uppercase text-danger'><?php echo @$error['address']?></div>
                        </div>


                        <div class="form-group">
                            <label for="faxNumber" class="col-sm-2 control-label">Fax</label>
                            <div class="col-sm-6">
                                <input class="form-control" name="fax" value="<?php echo @$_POST['fax']?>" />
                            </div>
                            <div class='small text-uppercase text-danger'><?php echo @$error['fax']?></div>
                        </div>


                        <div class="form-group">
                            <label for="wwwAdress" class="col-sm-2 control-label">www</label>
                            <div class="col-sm-6">
                                <input class="form-control" name="www" value="<?php echo @$_POST['www']?>" />
                            </div>
                            <div class='small text-uppercase text-danger'><?php echo @$error['www']?></div>
                        </div>

                        <div class="form-group">
                            <label for="notes" class="col-sm-2 control-label">Note</label>
                            <div class="col-sm-6">
                                <textarea class="form-control" name="note" rows="4" cols="50" /><?php echo @$_POST['note']?></textarea>
                            </div>
                            <div class='small text-uppercase text-danger'><?php echo @$error['note']?></div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-8">
                                <input class="btn btn-primary" id="btn_send" type="submit" name="send" value="ADD THIS"/>
                            </div>
                        </div>
                </form>

            </div>
        </article>
    </section>

</div>
<?php include 'includes/footer.php';
?>