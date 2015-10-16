<?php

include "class/vCard.php";

$contact = [];

function createClient ($param_pathToVcf) {
    if (file_exists($param_pathToVcf)) {
        $result = file_get_contents($param_pathToVcf);
        $newVCard = new VCard();
        $contact = $newVCard->extract($result);
        return $contact;
    }
}

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
    $pathToVcf = '../vcards/' . $server_filename;


    if ($status)
        return $pathToVcf;
    else
        return 'BLAD';

}


if (count($_FILES)) {
    $VCFpath = upload_file($_FILES['upload']);
    $contact = createClient($VCFpath);
    echo '<pre>';
    print_r($contact);
}

?>

<form action="?" method="post" enctype="multipart/form-data">
    Upload vCard:<input type="file" name="upload" value=""/><br/>
    <input type="submit" name="send" value="send" />
</form>
