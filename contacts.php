<?php

require_once('ContactDAO.php');

/**
 * Created by PhpStorm.
 * User: paoolskoolsky
 * Date: 09.10.15
 * Time: 16:27
 */
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
        try {
            $pdo = new PDO('mysql:dbname=infoshareaca_5;host=sql.infoshareaca.nazwa.pl', 'infoshareaca_5', 'F0r3v3r!');
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }

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
        if ($this->id !='') {
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
        $pdo = new PDO('mysql:dbname=infoshareaca_5;host=sql.infoshareaca.nazwa.pl', 'infoshareaca_5', 'F0r3v3r!');
        $stmt = $pdo->query('SELECT * FROM contacts');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete()
    {
        $this->pdo = new PDO('mysql:dbname=infoshareaca_5;host=sql.infoshareaca.nazwa.pl', 'infoshareaca_5', 'F0r3v3r!');
        $stmt = $this->pdo->prepare("DELETE FROM contacts WHERE idContact=:identyfikator");
        $status = $stmt->execute(
            array(
                ':identyfikator' => $this->id(),
            )
        );

        $this->id = null;
        $this->name = null;
        $this->phone = null;
        $this->photo = null;

        return $status;
    }
}

if (isset($_GET['contactid'])) {
    $contactDao = new ContactDAO();
    $newContact = $contactDao->loadContact($_GET['contactid']);
} else if (count($_POST)) {
    $newContact = new Contact(
        $_POST['surname'],
        $_POST['name'],
        $_POST['position'],
        $_POST['phone'],
        $_POST['email'],
        $_POST['city'],
        $_POST['linkedin'],
        $_POST['note']
    );
    if (isset($_POST['id'])) {
        $newContact->setId($_POST['id']);
    }
    $newContact->persist();
} else if (isset($_GET['delete'])) {
    $contactDao = Contact::createEmpty();
    $contactDao->setId($_GET['delete']);
    $contactDao->delete();
    $newContact = Contact::createEmpty();
} else {
    $newContact = Contact::createEmpty();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Formularz</title>

</head>
<body>


<form action="?" method="post">

    Surname: <input name="surname" value="<?php echo @$newContact->surname() ?>"/><br/>
    Name: <input name="name" value="<?php echo @$newContact->name() ?>"/><br/>
    Position: <input name="position" value="<?php echo $newContact->position() ?>"/><br/>
    Phone: <input name="phone" value="<?php echo @$newContact->phone() ?>"/><br/>
    E-mail: <input name="email" value="<?php echo @$newContact->email() ?>"/><br/>
    City: <input name="city" value="<?php echo @$newContact->city() ?>"/><br/>
    LinkedIn: <input name="linkedin" value="<?php echo @$newContact->linkedin() ?>"/><br/>
    Note:<textarea name="note"><?php echo @$newContact->note() ?></textarea><br/>
    <input type="text" name="id" value="<?php echo @$newContact->id() ?>">


    <input type="submit" name="send" value="SEND"/>
</form>

<br/>
<br/>

<a href="?">CLEAN FORM</a><br/>

<?php
echo '<table>';
echo '<tr>';
echo '<th>ID</th>';
echo '<th>Surname</th>';
echo '<th>Name</th>';
echo '<th>Position</th>';
echo '<th>Phone</th>';
echo '<th>Mail</th>';
echo '<th>City</th>';
echo '<th>LinkedIn</th>';
echo '<th>Note</th>';
echo '<th>OPTIONS</th>';
echo '</tr>';


$list = Contact::getList();
foreach ($list as $item) {
    echo '<tr>';
    echo '<td>' . $item['idContact'] . '</td>';
    echo '<td>' . $item['surnameContact'] . '</td>';
    echo '<td>' . $item['nameContact'] . '</td>';
    echo '<td>' . $item['positionContact'] . '</td>';
    echo '<td>' . $item['phoneContact'] . '</td>';
    echo '<td>' . $item['emailContact'] . '</td>';
    echo '<td>' . $item['cityContact'] . '</td>';
    echo '<td>' . $item['linkedinContact'] . '</td>';
    echo '<td>' . $item['noteContact'] . '</td>';
    echo '<td><a href="?contactid=' . $item['idContact'] . '">EDIT</a> <a href="?delete=' . $item['idContact'] . '">DELETE</a></td>';
    echo '</tr>';


}
echo '</table>';
echo '<br/><br/>';
?>
</body>
</html>

