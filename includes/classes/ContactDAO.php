<?php

require_once __DIR__ . '/DBConnection.php';

class ContactDAO
{

    public function loadContact($contactid)
    {
        $stmt = DBConnection::getConnection()->prepare("select * from contacts where idContact=:contactid");
        $stmt->execute(array(
            'contactid' => $contactid
        ));

        $contactData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($contactData) {
            $contact = new Contact ($contactData['surnameContact'], $contactData['nameContact'], $contactData['positionContact'], $contactData['phoneContact'], $contactData['emailContact'], $contactData['cityContact'], $contactData['linkedinContact'], $contactData['noteContact']);
            $contact->setId($contactData['idContact']);
            return $contact;
        } else {
            return Contact::createEmpty();
        }
    }
}
