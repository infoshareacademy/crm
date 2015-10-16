<?php

class Event {

    protected $idOfEvent;
    protected $topicOfEvent;
    protected $idClient;
    protected $idContact;
    protected $dateOfEvent;
    protected $timeOfEvent;
    protected $statusOfEvent;
    protected $typeOfEvent;
    protected $descriptionOfEvent;
    protected $outcomeOfEvent;

    protected $pdo;

    const EVENT_ARRANGED = 01;
    const EVENT_CONFIRMED = 02;
    const EVENT_COMPLETED = 03;
    const EVENT_CANCELLED = 04;

    const EVENT_TYPE_CALL = 01;
    const EVENT_TYPE_EMAIL = 02;
    const EVENT_TYPE_VIDEO = 03;
    const EVENT_TYPE_MEETING = 04;

    const OUTCOME_SUCCESS = 01;
    const OUTCOME_FAILURE = 02;
    const OUTCOME_FOLLOWUP = 03;

    const MAX_DESCRIPTION_LENGTH = 250;
    const MAX_TOPIC_LENGTH = 50;

//    CONSTRUCTOR is used for creation of a new Event and for updating the existing ones

    public function __construct($idOfEvent=null) {

//  shortcut for connection with DB - necessary for every action performed on an Event

        $this->pdo = new PDO('mysql:dbname=infoshareaca_5;host=sql.infoshareaca.nazwa.pl', 'infoshareaca_5', 'F0r3v3r!');

//  if Event has the id: 1. look for the record in DB

        if ($idOfEvent){
            $stmt = $this->pdo->query("SELECT * FROM events WHERE idOfEvent=".$idOfEvent);

            if ($stmt->rowCount()>0) {

//                       2. fetch the results only if query returned anything

                $result = $stmt->fetch(PDO::FETCH_ASSOC);

//                       3. constructor created an empty Event - now it must be filled out with data from DB

                $this->idOfEvent = $result['idOfEvent'];
                $this->topicOfEvent = $result['topicOfEvent'];
                $this->idClient = $result['idClient'];
                $this->idContact = $result['idContact'];
                $this->dateOfEvent = $result['dateOfEvent'];
                $this->timeOfEvent = $result['timeOfEvent'];
                $this->statusOfEvent = $result['statusOfEvent'];
                $this->typeOfEvent = $result['typeOfEvent'];
                $this->descriptionOfEvent = $result['descriptionOfEvent'];
                $this->outcomeOfEvent = @$result['outcomeOfEvent'];
            } else {
                throw new Exception ('Oups, there is no such Event. Please verify with the Administrator.');
            }
        }
    }

//    magical function used to set (and validate!) the value of all the protected params in the Event class

    public function __set($param_name, $param_value) {
        $this->$param_name = $param_value;
        switch ($param_name) {
            case 'idOfEvent':
                if (!$param_value)
                    $this->idOfEvent = null;
                else
                    $this->idOfEvent = $param_value;
                break;

            case 'topicOfEvent':
                if (!$param_value || strlen($param_value)>self::MAX_TOPIC_LENGTH)
                    $this->topicOfEvent = null;
                else
                    $this->topicOfEvent = htmlspecialchars($param_value);
                break;

            case 'idClient':
                if (!$param_value)
                    $this->idClient = null;
                else
                    $this->idClient = $param_value;
                break;

            case 'idContact':
                if (!$param_value)
                    $this->idContact = null;
                else
                    $this->idContact = $param_value;
                break;

            case 'dateOfEvent':
                if (!$param_value)
                    $this->dateOfEvent = null;
                else
                    $this->dateOfEvent = $param_value;
                break;

            case 'timeOfEvent':
                if (!$param_value)
                    $this->timeOfEvent = null;
                else
                    $this->timeOfEvent = $param_value;
                break;

            case 'statusOfEvent':
                if (!$param_value)
                    $this->statusOfEvent = null;
                else
                    $this->statusOfEvent = $param_value;
                break;

            case 'typeOfEvent':
                if (!$param_value)
                    $this->typeOfEvent = null;
                else
                    $this->typeOfEvent = $param_value;
                break;

            case 'outcomeOfEvent':
                if (!$param_value)
                    $this->outcomeOfEvent = null;
                else
                    $this->outcomeOfEvent = $param_value;
                break;

            case 'descriptionOfEvent':
                if (!$param_value || strlen($param_value)>self::MAX_DESCRIPTION_LENGTH)
                    $this->descriptionOfEvent = null;
                else
                    $this->descriptionOfEvent = htmlspecialchars($param_value);
                break;

            default:
                throw new Exception ('There is no such field!');
                break;
        }
    }

//    magical function allowing to get the value of all the protected params of the Event class

    public function __get($param_name) {
        return $this->$param_name;
    }


//    method inserting a newly created Event to DB

    private function _saveEvent(){

//        1. prepare the INSERT statement (stick to the naming convention - the same name of param in the Class and in the DB)
            $stmt = $this->pdo->prepare("INSERT INTO events (idClient,
                                                      idContact,
                                                       dateOfEvent,
                                                       timeOfEvent,
                                                       typeOfEvent,
                                                       statusOfEvent,
                                                       descriptionOfEvent,
                                                       topicOfEvent,
                                                       outcomeOfEvent) VALUES (
                                                                      :idClient,
                                                                      :idContact,
                                                                      :dateOfEvent,
                                                                      :timeOfEvent,
                                                                      :typeOfEvent,
                                                                      :statusOfEvent,
                                                                      :descriptionOfEvent,
                                                                      :topicOfEvent,
                                                                      :outcomeOfEvent
                             );"
            );

//        2. bind the params

        $input_parameters = array(
            ':idClient' => $this->idClient,
            ':idContact' => $this->idContact,
            ':dateOfEvent' => $this->dateOfEvent,
            ':timeOfEvent' => $this->timeOfEvent,
            ':typeOfEvent' => $this->typeOfEvent,
            ':statusOfEvent' => $this->statusOfEvent,
            ':descriptionOfEvent' => $this->descriptionOfEvent,
            ':topicOfEvent' => $this->topicOfEvent,
            ':outcomeOfEvent' => $this->outcomeOfEvent
        );

        $status = $stmt->execute($input_parameters);

//        3. callback assigning the ID from DB to the existing Object
//        (without this line every click on 'submit' will trigger saveEvent() and create a new row in DB!)
            $this->idOfEvent = $this->pdo->lastInsertId();

    }

//    method sending the updated Event to DB

    private function _editEvent(){
//      1. prepare the UPDATE statement (stick to the naming convention - the same name of param in the Class and in the DB)

        $stmt = $this->pdo->prepare("UPDATE events SET idClient=:idClient,
                                                          idContact=:idContact,
                                                          dateOfEvent=:dateOfEvent,
                                                          timeOfEvent=:timeOfEvent,
                                                          typeOfEvent=:typeOfEvent,
                                                          statusOfEvent=:statusOfEvent,
                                                          descriptionOfEvent=:descriptionOfEvent,
                                                          topicOfEvent=:topicOfEvent,
                                                          outcomeOfEvent=:outcomeOfEvent WHERE idOfEvent=:idOfEvent");
//      2. bind the params

        $input_parameters = array(
            ':idClient' => $this->idClient,
            ':idContact' => $this->idContact,
            ':dateOfEvent' => $this->dateOfEvent,
            ':timeOfEvent' => $this->timeOfEvent,
            ':typeOfEvent' => $this->typeOfEvent,
            ':statusOfEvent' => $this->statusOfEvent,
            ':descriptionOfEvent' => $this->descriptionOfEvent,
            ':topicOfEvent' => $this->topicOfEvent,
            ':outcomeOfEvent' => $this->outcomeOfEvent,
            ':idOfEvent' => $this->idOfEvent
        );
        $status = $stmt->execute($input_parameters);
    }

//    fork sending the info from the form to DB
// (if finds any ID in the hidden field in the form it will update the respective row instead of creating a new Insert)

    public function sendToDB(){
        try {
            (!$this->idOfEvent) ? $this->_saveEvent() : $this->_editEvent();

        } catch (Exception $e) {
            echo "________________________wm<br>$e->errorInfo";
        }
    }

//    function querying the DB, output is sent to the form page

    public static function displayFromEvents($selection){

 //  connection with DB

        $pdo = new PDO('mysql:dbname=infoshareaca_5;host=sql.infoshareaca.nazwa.pl', 'infoshareaca_5', 'F0r3v3r!');

//   function in used in a couple of places, query varies depending on the place where function is called
        switch ($selection) {

//   this switch prepares the query for drop-down 'Clients' in the form

            case 'Client':
                $stmt = $pdo->query('SELECT * FROM clients');
                break;

 //   this switch prepares the query for drop-down 'Contacts' in the form

            case 'Contact':
                $stmt = $pdo->query('SELECT * FROM contacts');
                break;

//   this switch prepares the query for the list of all Events

            case 'list':
                $stmt = $pdo->query('SELECT e.*, c.nameClient FROM events e INNER JOIN clients c ON e.idClient=c.idClient WHERE dateOfEvent >= CURDATE() - INTERVAL 3 DAY ORDER BY dateOfEvent;');
                break;
            default:
                echo 'Something went wrong!';
                break;
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

//    method deleting the chosen Event from DB

    public function deleteEvent() {

//      connection with DB and deleting the row based on the ID of Event from $_GET['delete']

        $stmt = $this->pdo->prepare("DELETE FROM events WHERE idOfEvent=:idOfEvent");
        $status = $stmt->execute(
            array(
                ':idOfEvent' => $this->idOfEvent,
            )
        );
// once the DB is updated the data from the Object is unset as well

        $this->idOfEvent = NULL;
        $this->topicOfEvent = NULL;
        $this->idClient = NULL;
        $this->idContact = NULL;
        $this->dateOfEvent = NULL;
        $this->timeOfEvent = NULL;
        $this->statusOfEvent = NULL;
        $this->typeOfEvent = NULL;
        $this->descriptionOfEvent = NULL;
        $this->outcomeOfEvent = NULL;

        return $status;
    }


}