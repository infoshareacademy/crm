<?php

/**
 * Created by PhpStorm.
 * User: katban
 * Date: 14.10.15
 * Time: 15:46
 */
class Client {
    protected $id;
    protected $name;
    protected $idTax;
    protected $address;
    protected $city;
    protected $phone;
    protected $fax;
    protected $www;
    protected $mail;
    protected $note;
    protected $date;

//
//    public function __construct($table=null) {
//        if (isset ($table)) {
//            foreach ($table as $key=>$value) {
//                $this->$key = $value;
//            }
//        }
//    }

    public function __set($parm_name, $parm_value) {
        return $this->$parm_name = $parm_value;
    }

    public function __get($parm_name) {
        return $this->$parm_name;
    }
}


$error = '';
// przejecie danych z posta
if (count($_POST)) {
    $client = new Client();

    if(!@$_POST['name'])
        $error = 'Nazwa firmy jest wymagana';
    else
        $client->name = @$_POST['name'];
    if(!@$_POST['phone'])
        $error = 'Pole telefon jest wymagane';
    else {
        //walidacja prosta przeniesci pozniej do creatora
        $client->phone = @$_POST['phone'];
        if (!preg_match('/[0-9]{9,11}/', $client->phone))
            $error = 'Telefon musi skladac sie z 9 do 11 cyfr';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>operacje na klietach</title>

</head>
<body>
<?php
if ($error) {
    echo '<div style="color:#f00;">'.$error.'</div><br/>';
}

echo '<form action="?" method="post">';
echo 'Nazwa: <input name="name" value="'.@$client->name.'"/><br/>';
echo 'NIP: <input name="idTax" value="'.@$client->idTax.'" /><br/>';
echo 'Adres[ulica;numer;kod]: <input name="address" value="" /><br/>';
echo 'Miasto: <input name="city" value="" /><br/>';
echo 'Telefon: <input name="phone" value="'.@$client->phone.'" /><br/>';
echo 'fax: <input name="fax" value="" /><br/>';
echo 'www: <input name="www" value="" /><br/>';
echo 'e-mail: <input name="mail" value="" /><br/>';
echo 'Note: <textarea name="note" value="" /></textarea>';
echo '<button id="btn_send">ZAPISZ</button>';
echo '</form>';

?>



</body>
</html>
