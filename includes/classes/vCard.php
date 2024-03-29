<?php
/**
 * Created by PhpStorm.
 * User: krasai
 * Date: 12.10.15
 * Time: 13:51
 */
class VCard {

    protected $vcfContent = '';
    protected $beginString = 'BEGIN:VCARD';
    protected $endString = 'END:VCARD';

    public $vCardData  = array (
        'version' => '',
        'email' => '',
        'name' => '',
        'surname' => '',
        'position' => '',
        'phone' => '',
        'city' => '',
    );

    protected $regexPatterns = array (
        'version' => array(
            '2.1' => '/^VERSION.*:(.*)\n/mi',
            '3.0' => '/^VERSION.*:(.*)\n/mi',
            '4.0' => '/^VERSION.*:(.*)\n/mi',
        ),
        'email' =>  array(
            '2.1' => '/^EMAIL.*:(.*)$/mi',
            '3.0' => '/^EMAIL.*:(.*)$/mi',
            '4.0' => '/^EMAIL.*:(.*)$/mi',
        ),
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
        'position' => array(
            '2.1' => '/^TITLE.*:(.*)\n/mi',
            '3.0' => '/^TITLE.*:(.*)\n/mi',
            '4.0' => '/^TITLE.*:(.*)\n/mi',
        ),
        'phone' => array(
            '2.1' => '/^TEL.*work.*:(.*)\n/mi',
            '3.0' => '/^TEL.*work.*:(.*)\n/mi',
            '4.0' => '/^TEL.*work.*:(.*)\n/mi',
        ),
        'city' => array(
                '2.1' => '/^ADR.*work.*:.*;(.*);.*;.*;.*\n/mi',
                '3.0' => '/^ADR.*type=work.*:.*;(.*);.*;.*;.*\n/mi',
                '4.0' => '/^ADR.*type=work.*[\n]*.*:.*;(.*);.*;.*;.*\n/mi',
        ),
    );


    public function extract($param_vcard){
        $this->vcfContent = $param_vcard;
        $this->checkIfVCard();
        if (!($this->vCardData['version']))
            return false;

        $this->separateStrings();
        return $this->vCardData;
    }

    private function checkIfVCard() {
        if ($this->beginString != substr($this->vcfContent, 0, strlen($this->beginString)) ||
            $this->endString != substr(trim($this->vcfContent), -strlen($this->endString)))
            return false;

        if (preg_match('/\bVERSION:\b\d[.]\d/i', $this->vcfContent, $metches)){
            $this->vCardData['version'] = trim(substr($metches[0], -3));
            return $this->vCardData['version'];
        } else return false;
    }

    private function separateStrings() {
        foreach($this->vCardData as $k => $v){
            if(preg_match_all($this->regexPatterns[$k][trim($this->vCardData['version'])], $this->vcfContent, $metches))
                if(count($metches[1][0]))
                    $this->vCardData[$k] = $metches[1][0];
                else $this->vCardData[$k] = '';
        }
    }

}