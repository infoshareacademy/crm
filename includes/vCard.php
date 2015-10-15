<?php
/**
 * Created by PhpStorm.
 * User: krasai
 * Date: 12.10.15
 * Time: 13:51
 */
class VCard {

    protected $vcarddata = '';
    protected $beginString = 'BEGIN:VCARD';
    protected $endString = 'END:VCARD';

    public $vCardData = [];

    protected $regexPatterns = array(
            'version' => '/\bEMAIL\b.+\n/i',
            'email' => '/\bEMAIL\b.+\n/i',
            'name' => '/\bN\b:.+\n/i',
            'surname' => '/\bN\b:.+\n/i',
            'position' => '/\bTITLE\b.+\n/i',
            'phone' => '/\bTEL\b.*work.*\d*\n/i',
            'city' => array(
                    '21' => '/^ADR.*work.*:.*;(.*);.*;.*;.*\n/mi',
                    '30' => '/^ADR.*type=work.*:.*;(.*);.*;.*;.*\n/mi',
                    '40' => '/^ADR.*type=work.*[\n]*.*:.*;(.*);.*;.*;.*\n/mi',
                    ),
            );

    protected $version = '';
    protected $surnameContact = '';
    protected $nameContact = '';
    protected $positionContact = '';
    protected $phoneContact = '';
    protected $emailContact = '';
    protected $cityContact = '';

    public function extract($param_vcard)
    {
        $this->vcarddata = $param_vcard;
        $this->vCardData['version'] = $this->checkIfVCard();
        if (!$this->vCardData['version'])
            return false;

        if (preg_match('/\bEMAIL\b.+\n/i', $this->vcarddata, $this->emailContact))
            $this->vCardData['email'] = trim(substr($this->emailContact[0], strpos($this->emailContact[0], ':') + 1));
        else
            $this->vCardData['email'] = '';

        if (preg_match('/\bN\b:.+\n/i', $this->vcarddata, $this->nameContact)) {
            $this->nameContact = trim(substr($this->nameContact[0], strpos($this->nameContact[0], ':') + 1));
            $this->nameContact = explode(';', $this->nameContact);
            $this->vCardData['name'] = $this->nameContact[1];
            $this->vCardData['surname'] = $this->nameContact[0];
        } else {
            $this->vCardData['name'] = '';
            $this->vCardData['surname'] = '';
        }

        if (preg_match('/\bTITLE\b.+\n/i', $this->vcarddata, $this->positionContact))
            $this->vCardData['position'] = trim(substr($this->positionContact[0], strpos($this->positionContact[0], ':') + 1));
        else
            $this->vCardData['position']='';


        if (preg_match('/\bTEL\b.*work.*\d*\n/i', $this->vcarddata, $this->phoneContact))
            $this->vCardData['phone'] = trim(substr($this->phoneContact[0], strrpos($this->phoneContact[0], ':') + 1));
        else
            $this->vCardData['phone'] = '';

        if($this->vCardData['version'] == '2.1') {
            if (preg_match('/^ADR.*work.*:.*;(.*);.*;.*;.*\n/mi', $this->vcarddata, $this->cityContact))
                $this->vCardData['city'] = $this->cityContact[1];
            else
                $this->vCardData['city'] = '';
        } else if($this->vCardData['version'] == '4.0') {
            if (preg_match('/^ADR.*type=work.*[\n]*.*:.*;(.*);.*;.*;.*\n/mi', $this->vcarddata, $this->cityContact))
                $this->vCardData['city'] = $this->cityContact[1];
            else
                $this->vCardData['city'] = '';
        } else {
            if (preg_match_all('/^ADR.*type=work.*:.*;(.*);.*;.*;.*\n/mi', $this->vcarddata, $this->cityContact))
                $this->vCardData['city'] = $this->cityContact[1][0];
            else
                $this->vCardData['city'] = '';
        }

        return $this->vCardData;
    }


    private function checkIfVCard(){
        if ($this->beginString != substr($this->vcarddata, 0, strlen($this->beginString)))
            return false;

        if ($this->endString != substr($this->vcarddata, -strlen($this->endString)))
            return false;

        if (preg_match('/\bVERSION:\b\d[.]\d/i', $this->vcarddata, $this->version))
            return substr($this->version[0], -3);
        else return false;
    }

    public function separateStringFrom($param_name) {
        switch($param_name){
            case 'name':
                break;
            case 'surname:':
                break;
            default:

                break;
        }


        return $this->$param_name;
    }


}