<?php

require_once __DIR__ . '/DBConnection.php';

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

    public function __construct($idOfEvent=null) {
        $this->pdo = DBConnection::getConnection();

        if ($idOfEvent){
            $stmt = $this->pdo->query("SELECT * FROM events WHERE idOfEvent=".$idOfEvent);
            if ($stmt->rowCount()>0) {

                $result = $stmt->fetch(PDO::FETCH_ASSOC);

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

    public function __get($param_name) {
        return $this->$param_name;
    }

    private function _saveNewEvent(){

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

            $this->idOfEvent = $this->pdo->lastInsertId();

    }

    private function _editEvent(){

        $stmt = $this->pdo->prepare("UPDATE events SET idClient=:idClient,
                                                       idContact=:idContact,
                                                       dateOfEvent=:dateOfEvent,   
                                                       timeOfEvent=:timeOfEvent,
                                                       typeOfEvent=:typeOfEvent   ,
                                                       statusOfEvent=:statusOfEvent,
                                                       descriptionOfEvent=:descriptionOfEvent,
                                                       topicOfEvent=:topicOfEvent   ,
                                                       outcomeOfEvent=:outcomeOfEvent
                                                 WHERE idOfEvent=:idOfEvent") ;

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

    public function sendToDB(){
        try {
            (!$this->idOfEvent) ? $this->_saveNewEvent() : $this->_editEvent();
        } catch (Exception $e) {
            echo "$e->errorInfo";
        }
    }

    public static function displayFromEvents($selection){

        $pdo = DBConnection::getConnection();

        switch ($selection) {

            case 'Client':
                $stmt = $pdo->query('SELECT * FROM clients');
                break;

            case 'Contact':
                $stmt = $pdo->query('SELECT * FROM contacts');
                break;

            case 'list':
                $stmt = $pdo->query('SELECT e.*, c.nameClient FROM events e INNER JOIN clients c ON e.idClient=c.idClient
WHERE dateOfEvent >= (CURDATE() - INTERVAL 3 DAY) ORDER BY dateOfEvent LIMIT 25 ;');
                break;

            default:
                echo 'Something went wrong!';
                break;
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteEvent() {

        $stmt = $this->pdo->prepare("DELETE FROM events WHERE idOfEvent=:idOfEvent");
        $status = $stmt->execute(
            array(
                ':idOfEvent' => $this->idOfEvent,
            )
        );

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