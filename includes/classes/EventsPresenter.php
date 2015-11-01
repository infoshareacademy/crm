<?php

class EventsPresenter extends Event
{
    public static function translateStatusOfEvent($statusOfEvent){
        switch ($statusOfEvent){
            case Event::EVENT_ARRANGED:
                return "Arranged";
            case Event::EVENT_CONFIRMED:
                return "Confirmed";
            case Event::EVENT_COMPLETED:
                return "Completed";
            case Event::EVENT_CANCELLED:
                return "Cancelled";
            default:
                return "--missing status--";
        }
    }

    public static function translateTypeOfEvent($typeOfEvent){
        switch ($typeOfEvent){
            case Event::EVENT_TYPE_CALL:
                return "Call";
            case Event::EVENT_TYPE_EMAIL:
                return "Email";
            case Event::EVENT_TYPE_MEETING:
                return "Meeting";
            case Event::EVENT_TYPE_VIDEO:
                return "Video conference";
            default:
                return "missing type";
        }
    }

    public static function translateOutcomeOfEvent($outcomeOfEvent){
        switch ($outcomeOfEvent){
            case Event::OUTCOME_SUCCESS:
                return "success";
            case Event::OUTCOME_FOLLOWUP:
                return "follow up";
            case Event::OUTCOME_FAILURE:
                return "failure";
            default:
                return "missing outcome";
        }
    }

    public static function translateMonthOfEvent($monthOfEvent){
        switch ($monthOfEvent){
            case 1:
                return 'January';
            case 2:
                return 'February';
            case 3:
                return 'March';
            case 4:
                return 'April';
            case 5:
                return 'March';
            case 6:
                return 'January';
            case 7:
                return 'January';
            case 8:
                return 'January';
            case 9:
                return 'January';
            case 10:
                return 'January';
            case 11:
                return 'January';
            case 12:
                return 'January';
            default:
                return 'Missing month';
        }
    }
}