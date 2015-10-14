<?php

class Event {

    protected $topicOfEvent;
    protected $idClient;
    protected $dateOfEvent;
    protected $timeOfEvent;
    protected $statusOfEvent;
    protected $descriptionOfEvent;
    protected $typeOfEvent;
    protected $idContact;
    protected $idOfEvent;
    protected $outcomeOfEvent;

    private $pdo;

    const SEND_TO_DB_OK = 1;
    const SEND_TO_DB_FAIL = -1;

    const EVENT_ARRANGED = 01;
    const EVENT_CONFIRMED = 02;
    const EVENT_COMPLETED = 03;
    const EVENT_CANCELLED = 04;

    const OUTCOME_SUCCESS = 01;
    const OUTCOME_FAILURE = 02;
    const OUTCOME_FOLLOWUP = 03;

    const MAX_DESCRIPTION_LENGTH = 250;
    const MAX_TOPIC_LENGTH = 50;

    public function __construct() {
        $this->pdo = new PDO('mysql:dbname=infoshareaca_5;host=sql.infoshareaca.nazwa.pl', 'infoshareaca_5', 'F0r3v3r!');
    }

    public function __set($param_name, $param_value) {
        $this->$param_name = $param_value;
        switch ($param_name) {
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


    private function _sendToDB(){
        try {
            $stmt = $this->pdo->prepare("INSERT INTO events (idClient,
                                                       dateEvent,
                                                       timeEvent,
                                                       typeEvent,
                                                       statusEvent,
                                                       descriptionEvent,
                                                       topicEvent) VALUES (
                                                                      :idClient,
                                                                      :dateOfEvent,
                                                                      :timeOfEvent,
                                                                      :typeOfEvent,
                                                                      :statusOfEvent,
                                                                      :descriptionOfEvent,
                                                                      :topicOfEvent
                             );"
            );

            $status = $stmt->execute(array(
                    ':idClient' => $this->idClient,
                    ':dateOfEvent' => $this->dateOfEvent,
                    ':timeOfEvent' => $this->timeOfEvent,
                    ':typeOfEvent' => $this->typeOfEvent,
                    ':statusOfEvent' => $this->statusOfEvent,
                    ':descriptionOfEvent' => $this->descriptionOfEvent,
                    ':topicOfEvent' => $this->topicOfEvent
                )
            );

            $this->idOfEvent = $this->pdo->lastInsertId();

            if ($status)
                return self::SEND_TO_DB_OK;
            else
                return self::SEND_TO_DB_FAIL;

        } catch(Exception $e) {
            print_r($e->getMessage());
        }
    }
//
//    private function editEvent(){
//
//    }

    public function saveEvent(){
        $this->_sendToDB();
    }



}