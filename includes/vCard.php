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
        else return false;

        if (preg_match('/\bN\b:.+\n/i', $this->vcarddata, $this->nameContact)) {
            $this->nameContact = trim(substr($this->nameContact[0], strpos($this->nameContact[0], ':') + 1));
            $this->nameContact = explode(';', $this->nameContact);
            $this->vCardData['name'] = $this->nameContact[1];
            $this->vCardData['surname'] = $this->nameContact[0];
        } else return false;

        if (preg_match('/\bTITLE\b.+\n/i', $this->vcarddata, $this->positionContact))
            $this->vCardData['position'] = trim(substr($this->positionContact[0], strpos($this->positionContact[0], ':') + 1));
        else return false;


        if (preg_match('/\bTEL\b.*work.*\d*\n/i', $this->vcarddata, $this->phoneContact))
            $this->vCardData['phone'] = trim(substr($this->phoneContact[0], strrpos($this->phoneContact[0], ':') + 1));
        else return false;

        if (preg_match('/\bADR\b.*work.*\n.*/i', $this->vcarddata, $this->cityContact)){
                $this->cityContact = explode(';', trim(substr($this->cityContact[0], strrpos($this->cityContact[0], ':') + 1)));
                $this->vCardData['city'] = $this->cityContact[3];
        } else return false;

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


}