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
            'version' => '/^VERSION.*:(.*)\n/mi',
            'email' => '/^EMAIL.*:(.*)$/mi',
            'name' => array(
                    '2.1' => '/^N.*:.*;(.*)$/mi',
                    '3.0' => '/^N.*:.*;(.*);.*;.*$/mi',
                    '4.0' => '/^N.*:.*;(.*);.*;.*;.*$/mi',
                ),
            'surname' => array(
                    '2.1' => '/^N.*:(.*);.*$/mi',
                    '3.0' => '/^N.*:(.*);.*;.*;.*$/mi',
                    '4.0' => '/^N.*:(.*);.*;.*;.*;.*$/mi',
                ),
            'position' => '/^TITLE.*:(.*)\n/mi',
            'phone' => '/^TEL.*work.*:(.*)\n/mi',
            'city' => array(
                    '2.1' => '/^ADR.*work.*:.*;(.*);.*;.*;.*\n/mi',
                    '3.0' => '/^ADR.*type=work.*:.*;(.*);.*;.*;.*\n/mi',
                    '4.0' => '/^ADR.*type=work.*[\n]*.*:.*;(.*);.*;.*;.*\n/mi',
                ),
            );

    protected $version = '';
    protected $surnameContact = '';
    protected $nameContact = '';
    protected $positionContact = '';
    protected $phoneContact = '';
    protected $emailContact = '';
    protected $cityContact = '';

    public function extract($param_vcard){
        $this->vcarddata = $param_vcard;

        $this->vCardData['version'] = $this->checkIfVCard();
        if (!$this->vCardData['version'])
            return 'Nieprawidlowy vCard <br>' . $param_vcard;

            $this->vCardData['email'] = $this->separateStringFrom('email');
            $this->vCardData['name'] = $this->separateStringFrom('name');
            $this->vCardData['surname'] = $this->separateStringFrom('surname');
            $this->vCardData['position'] = $this->separateStringFrom('position');
            $this->vCardData['phone'] = $this->separateStringFrom('phone');
            $this->vCardData['city'] = $this->separateStringFrom('city');
        return $this->vCardData;
    }


    private function checkIfVCard(){
        if ($this->beginString != substr($this->vcarddata, 0, strlen($this->beginString)))
            return false;

        if ($this->endString != substr(trim($this->vcarddata), -strlen($this->endString)))
            return false;

        if (preg_match('/\bVERSION:\b\d[.]\d/i', $this->vcarddata, $this->version))
            return substr($this->version[0], -3);
        else return false;
    }

    public function separateStringFrom($param_name) {

        switch($param_name){
            case 'name':
                if ($this->vCardData['version'] == '2.1'
                    && preg_match_all($this->regexPatterns['name']['2.1'], $this->vcarddata, $metches)) {
                    return $metches[1][0];
                } else if ($this->vCardData['version'] == '3.0'
                    && preg_match_all($this->regexPatterns['name']['3.0'], $this->vcarddata, $metches)) {
                    return $metches[1][0];
                } else if ($this->vCardData['version'] == '4.0'
                    && preg_match_all($this->regexPatterns['name']['4.0'], $this->vcarddata, $metches)) {
                    return $metches[1][0];
                } else {
                    return '';
                }
                break;
            case 'surname':
                if ($this->vCardData['version'] == '2.1'
                    && preg_match_all($this->regexPatterns['surname']['2.1'], $this->vcarddata, $metches)) {
                    return $metches[1][0];
                } else if ($this->vCardData['version'] == '3.0'
                    && preg_match_all($this->regexPatterns['surname']['3.0'], $this->vcarddata, $metches)) {
                    return $metches[1][0];
                } else if ($this->vCardData['version'] == '4.0'
                    && preg_match_all($this->regexPatterns['surname']['4.0'], $this->vcarddata, $metches)) {
                    return $metches[1][0];
                } else {
                    return '';
                }
                break;
            case 'email':
                    if (preg_match_all($this->regexPatterns['email'], $this->vcarddata, $metches))
                        return $metches[1][0];
                    else
                        return '';
                break;
            case 'position':
                    if (preg_match_all($this->regexPatterns['position'], $this->vcarddata, $metches))
                        return $metches[1][0];
                    else
                        return '';
                break;
            case 'phone':
                    if (preg_match_all($this->regexPatterns['phone'], $this->vcarddata, $metches))
                        return $metches[1][0];
                    else
                        return '';
                break;
            case 'city':
                if ($this->vCardData['version'] == '2.1'
                    && preg_match_all($this->regexPatterns['city']['2.1'], $this->vcarddata, $metches)) {
                    return $metches[1][0];
                } else if ($this->vCardData['version'] == '3.0'
                    && preg_match_all($this->regexPatterns['city']['3.0'], $this->vcarddata, $metches)) {
                    return $metches[1][0];
                } else if ($this->vCardData['version'] == '4.0'
                    && preg_match_all($this->regexPatterns['city']['4.0'], $this->vcarddata, $metches)) {
                    return $metches[1][0];
                } else {
                    return '';
                }
                break;
            default:
                break;
        }

    }


}