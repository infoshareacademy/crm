<?php

class ContactDAO
{

    public function loadContact($contactid)
    {
        $pdo = new PDO('mysql:dbname=infoshareaca_5;host=sql.infoshareaca.nazwa.pl', 'infoshareaca_5', 'F0r3v3r!');
        $result = $pdo->query("select * from contacts where idContact=$contactid");

        if ($result->rowCount() > 0) {
            $contactData = $result->fetch();
            $contact = new Contact ($contactData['surnameContact'], $contactData['nameContact'], $contactData['positionContact'], $contactData['phoneContact'], $contactData['emailContact'], $contactData['cityContact'], $contactData['linkedinContact'], $contactData['noteContact']);
            $contact->setId($contactData['idContact']);
            return $contact;
        } else {
            return Contact::createEmpty();
        }
    }
}

?>