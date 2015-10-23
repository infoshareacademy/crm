<?php

require_once __DIR__ . '/DBConnection.php';

class ContactDAO
{

    public function loadContact($contactid)
    {
        $pdo = DBConnection::getConnection();
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