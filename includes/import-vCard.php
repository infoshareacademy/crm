<?php

include "vCard.php";


function upload_file($file_field, $force_type='') {
    $user_filename = $file_field['name'];
    $extension = substr($user_filename, strrpos($user_filename, '.')+1, 5);
    $result = '';

    do {
        $hash = uniqid(rand(0, 99999));
        $server_filename = $hash . '.' . $extension;
    } while (file_exists('../vcards/' . $server_filename));

    // kopiowanie pliku z katalogu tymczasowego do naszego projektu "podkatalogu TEST"
    $status = move_uploaded_file($file_field['tmp_name'], '../vcards/' . $server_filename);

    if (file_exists('../vcards/' . $server_filename))
        $result = file_get_contents('../vcards/' . $server_filename);
$zmien = '';
    $newVCard = new VCard();
//    $zmien = $newVCard->extract($result);
    $newVCard->extract('BEGIN:VCARD
VERSION:2.1
N:Gump;Forrest
FN:Forrest Gump
ORG:Bubba Gump Shrimp Co.
TITLE:Shrimp Man
PHOTO;GIF:http://www.example.com/dir_photos/my_photo.gif
TEL;WORK;VOICE:(111) 555-1212
TEL;HOME;VOICE:(404) 555-1212
ADR;WORK:;;100 Waters Edge;Baytown;LA;30314;United States of America
LABEL;WORK;ENCODING=QUOTED-PRINTABLE:100 Waters Edge=0D=0ABaytown, LA 30314=0D=0AUnited States of America
ADR;HOME:;;42 Plantation St.;Baytown;LA;30314;United States of America
LABEL;HOME;ENCODING=QUOTED-PRINTABLE:42 Plantation St.=0D=0ABaytown, LA 30314=0D=0AUnited States of America
EMAIL;PREF;INTERNET:forrestgump@example.com
REV:20080424T195243Z
END:VCARD');



    // sprawdzenie typu mime uploadowanego pliku
    //    $mime = mime_content_type('../vcards/' . $server_filename);
    //    if ($force_type && $force_type!=$mime) {
    //        unlink('../vcards/' . $server_filename);
    //        return 'BLEDNY TYP PLIKU, WYMAGAMY '.$force_type;
    //    }

    if ($status)
        return 'OK' . $zmien;
    else
        return 'BLAD' . $zmien;

}


if (count($_FILES)) {
    $status = upload_file($_FILES['upload']);
    var_dump($status);
}

?>

<form action="?" method="post" enctype="multipart/form-data">
    Upload vCard:<input type="file" name="upload" value=""/><br/>
    <input type="submit" name="send" value="send" />
</form>
