<?php

/**
 * Created by PhpStorm.
 * User: paoolskoolsky
 * Date: 15.10.15
 * Time: 16:38
 */
require_once __DIR__ . '/DBConnection.php';

class Contact
{
    protected $idContact;
    protected $idClient;
    protected $surnameContact;
    protected $nameContact;
    protected $positionContact;
    protected $phoneContact;
    protected $emailContact;
    protected $cityContact;
    protected $linkedinContact;
    protected $noteContact;
    protected $creationDateContact;
    protected $id;


    public function __construct($surnameContact, $nameContact, $positionContact, $phoneContact, $emailContact, $cityContact, $linkedinContact, $noteContact)
    {
        $this->surnameContact = $surnameContact;
        $this->nameContact = $nameContact;
        $this->positionContact = $positionContact;
        $this->phoneContact = $phoneContact;
        $this->emailContact = $emailContact;
        $this->cityContact = $cityContact;
        $this->linkedinContact = $linkedinContact;
        $this->noteContact = $noteContact;

    }

    public function persist()
    {

        $pdo = DBConnection::getConnection();


        $queryParameters = array(
            ':surnameContact' => $this->surname(),
            ':nameContact' => $this->name(),
            ':positionContact' => $this->position(),
            ':phoneContact' => $this->phone(),
            ':emailContact' => $this->email(),
            ':cityContact' => $this->city(),
            ':linkedinContact' => $this->linkedin(),
            ':noteContact' => $this->note()
        );
        if ($this->id != '') {
            $dbQuery = "UPDATE contacts SET
            surnameContact = :surnameContact,
            nameContact = :nameContact,
            positionContact = :positionContact,
            phoneContact = :phoneContact,
            emailContact = :emailContact,
            cityContact = :cityContact,
            linkedinContact = :linkedinContact,
            noteContact = :noteContact
            WHERE idContact = :idContact";
            $queryParameters = array_merge($queryParameters, array(':idContact' => $this->id()));
        } else {
            $dbQuery = "INSERT INTO contacts (
                surnameContact,
                nameContact,
                positionContact,
                phoneContact,
                emailContact,
                cityContact,
                linkedinContact,
                noteContact)
                 VALUES (
                :surnameContact,
                :nameContact,
                :positionContact,
                :phoneContact,
                :emailContact,
                :cityContact,
                :linkedinContact,
                :noteContact)";
        }
        $stmt = $pdo->prepare($dbQuery);
        $stmt->execute($queryParameters);
    }

    static function createEmpty()
    {
        return new Contact(NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
    }

    public function surname()
    {

        return $this->surnameContact;
    }

    public function name()
    {
        return $this->nameContact;
    }

    public function position()
    {
        return $this->positionContact;
    }

    public function phone()
    {
        return $this->phoneContact;
    }

    public function email()
    {
        return $this->emailContact;
    }

    public function city()
    {
        return $this->cityContact;
    }

    public function linkedin()
    {
        return $this->linkedinContact;
    }

    public function  note()
    {
        return $this->noteContact;
    }

    public function id()
    {
        return $this->id;
    }

    public function setId($newId)
    {
        $this->id = $newId;
    }

    public static function getList()
    {
        $pdo = DBConnection::getConnection();
        $stmt = $pdo->query('SELECT * FROM contacts');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete()
    {
        $this->pdo = DBConnection::getConnection();
        $stmt = $this->pdo->prepare("DELETE FROM contacts WHERE idContact=:identyfikator");
        $status = $stmt->execute(
            array(
                ':identyfikator' => $this->id(),
            )
        );

        return $status;
    }

    public function isValid()
    {
        $error = array();
        if (!$this->surnameContact || !preg_match('/^[a-zA-Z]+$/', $this->surnameContact)) {
            $error['surname'] = 'Surname must contain letters only';
        };
        if (!$this->nameContact || !preg_match('/^[a-zA-Z]+$/', $this->nameContact)) {
            $error['name'] = 'Name must contain letters only';

        };
        if (!$this->positionContact || !preg_match('/^[a-zA-Z]+$/', $this->positionContact)) {
            $error['position'] = 'Position must contain letters only';

        };
        if (!$this->phoneContact || !preg_match('/^[0-9]{9,13}$/', $this->phoneContact)) {
            $error['phone'] = 'Phone must contain numbers (min->9 max->13) only';

        };
        if (!$this->emailContact || !preg_match('/^([a-z0-9-_.]{1,})@[a-z0-9-]+(.[a-z0-9]{2,})$/i', $this->emailContact)) {
            $error['email'] = 'Please keep real email format...';

        };
        if (!$this->cityContact || !preg_match('/^[a-zA-Z]+$/', $this->cityContact)) {
            $error['city'] = 'City must contain letters only';

        };
        if (!$this->linkedinContact || !preg_match('/^(ftp|http|https):\/\/?((www|\w\w)\.)?linkedin.com(\w+:{0,1}\w*@)?(\S+)(:([0-9])+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?$/', $this->linkedinContact)) {
            $error['linkedin'] = 'Please keep real LinkedIn URL format...';

        };
        return $error;
    }
}
