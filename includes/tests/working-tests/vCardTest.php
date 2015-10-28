<?php

require_once __DIR__ . '/../../classes/vCard.php';

/**
 * Created by PhpStorm.
 * User: krasai
 * Date: 12.10.15
 * Time: 13:50
 */
class vCardTest extends PHPUnit_Framework_TestCase
{
    protected $vcard;
    protected $vCardData;

    public function setUp() {
        $this->vcard = new VCard();
    }


    public function testIfVCardV21() {
        $vcard = new VCard();
        $vCardData = $vcard->extract('BEGIN:VCARD
VERSION:2.1
N:Gump;Forrest
FN:Forrest Gump
ORG:Bubba Gump Shrimp Co.
TITLE:Shrimp Man
PHOTO;GIF:http://www.example.com/dir_photos/my_photo.gif
TEL;WORK;VOICE:(111) 555-1212
TEL;HOME;VOICE:(404) 555-1212
ADR;WORK:;;100 Waters Edge;Baytown;LA;30314;United States of America
LABEL;WORK;ENCODING=QUOTED-PRINTABLE:100 Waters Edge=0D=0ABaytown, LA 30314=0D=0AUnited States of America
ADR;HOME:;;42 Plantation St.;Baytown;LA;30314;United States of America
LABEL;HOME;ENCODING=QUOTED-PRINTABLE:42 Plantation St.=0D=0ABaytown, LA 30314=0D=0AUnited States of America
EMAIL;PREF;INTERNET:forrestgump@example.com
REV:20080424T195243Z
END:VCARD');
        $this->assertEquals('2.1',                      $vCardData['version']);
        $this->assertEquals('forrestgump@example.com',  $vCardData['email']);
        $this->assertEquals('Forrest',                  $vCardData['name']);
        $this->assertEquals('Gump',                     $vCardData['surname']);
        $this->assertEquals('Shrimp Man',               $vCardData['position']);
        $this->assertEquals('(111) 555-1212',           $vCardData['phone']);
        $this->assertEquals('Baytown',                  $vCardData['city']);

    }

    public function testIfVCardV30() {
        $vcard = new VCard();
        $vCardData = $vcard->extract('BEGIN:VCARD
VERSION:3.0
N:Gump;Forrest;;Mr.
FN:Forrest Gump
ORG:Bubba Gump Shrimp Co.
TITLE:Shrimp Man
PHOTO;VALUE=URL;TYPE=GIF:http://www.example.com/dir_photos/my_photo.gif
TEL;TYPE=WORK,VOICE:(111) 555-1212
TEL;TYPE=HOME,VOICE:(404) 555-1212
ADR;TYPE=WORK:;;100 Waters Edge;Baytown;LA;30314;United States of America
LABEL;TYPE=WORK:100 Waters Edge\nBaytown\, LA 30314\nUnited States of Ameri
 ca
ADR;TYPE=HOME:;;42 Plantation St.;Baytown;LA;30314;United States of America
LABEL;TYPE=HOME:42 Plantation St.\nBaytown\, LA 30314\nUnited States of Ame
 rica
EMAIL;TYPE=PREF,INTERNET:forrestgump@example.com
REV:2008-04-24T19:52:43Z
END:VCARD');
        $this->assertEquals($vCardData['version'],  '3.0');
        $this->assertEquals($vCardData['email'],    'forrestgump@example.com');
        $this->assertEquals($vCardData['name'],     'Forrest');
        $this->assertEquals($vCardData['surname'],  'Gump');
        $this->assertEquals($vCardData['position'], 'Shrimp Man');
        $this->assertEquals('(111) 555-1212',        $vCardData['phone']);
        $this->assertEquals('Baytown',               $vCardData['city']);
    }

    public function testIfVCardV40() {
        $vcard = new VCard();
        $vCardData = $vcard->extract('BEGIN:VCARD
VERSION:4.0
N:Gump;Forrest;;;
FN:Forrest Gump
ORG:Bubba Gump Shrimp Co.
TITLE:Shrimp Man
PHOTO;MEDIATYPE=image/gif:http://www.example.com/dir_photos/my_photo.gif
TEL;TYPE=work,voice;VALUE=uri:tel:+11115551212
TEL;TYPE=home,voice;VALUE=uri:tel:+14045551212
ADR;TYPE=work;LABEL="100 Waters Edge\nBaytown, LA 30314\nUnited States of A
 merica":;;100 Waters Edge;Baytown;LA;30314;United States of America
ADR;TYPE=home;LABEL="42 Plantation St.\nBaytown, LA 30314\nUnited States of
 America":;;42 Plantation St.;Baytown;LA;30314;United States of America
EMAIL:forrestgump@example.com
REV:20080424T195243Z
END:VCARD');
        $this->assertEquals($vCardData['version'],  '4.0');
        $this->assertEquals($vCardData['email'],    'forrestgump@example.com');
        $this->assertEquals($vCardData['name'],     'Forrest');
        $this->assertEquals($vCardData['surname'],  'Gump');
        $this->assertEquals($vCardData['position'], 'Shrimp Man');
        $this->assertEquals('+11115551212',        $vCardData['phone']);
        $this->assertEquals('Baytown',               $vCardData['city']);
    }


    public function testIfVCardNew() {
        $vcard = new VCard();
        $vCardData = $vcard->extract('BEGIN:VCARD
VERSION:3.0
N:Doe;John;Q.;Public
FN:John Doe
TEL;TYPE=WORK,VOICE:(111) 555-1212
TEL;TYPE=HOME,VOICE:(404) 555-1212
TEL;TYPE=HOME,TYPE=VOICE:(404) 555-1213
EMAIL;TYPE=PREF,INTERNET:forrestgump@example.com
EMAIL;TYPE=INTERNET:example@example.com
PHOTO;VALUE=URL;TYPE=PNG:http://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/Example_svg.svg/200px-Example_svg.svg.png
END:VCARD');
        $this->assertEquals('3.0', $vCardData['version'] );
        $this->assertEquals('forrestgump@example.com', $vCardData['email'] );
        $this->assertEquals('John', $vCardData['name']);
        $this->assertEquals('Doe', $vCardData['surname']);
        $this->assertEquals('', $vCardData['position']);
        $this->assertEquals('(111) 555-1212', $vCardData['phone']);
        $this->assertEquals('', $vCardData['city']);
    }



    public function testInvalidVCard() {
        $vcard = new VCard();
        $vCardData = $vcard->extract('
VERSION:5.0
N:Gump;Forrest;;;
FN:Forrest Gump
ORG:Bubba Gump Shrimp Co.
TITLE:Shrimp Man
PHOTO;MEDIATYPE=image/gif:http://www.example.com/dir_photos/my_photo.gif
TEL;TYPE=work,voice;VALUE=uri:tel:+11115551212
TEL;TYPE=home,voice;VALUE=uri:tel:+14045551212
ADR;TYPE=work;LABEL="100 Waters Edge\nBaytown, LA 30314\nUnited States of A
 merica":;;100 Waters Edge;Baytown;LA;30314;United States of America
ADR;TYPE=home;LABEL="42 Plantation St.\nBaytown, LA 30314\nUnited States of
 America":;;42 Plantation St.;Baytown;LA;30314;United States of America
EMAIL:forrestgump@example.com
REV:20080424T195243Z
END:VCARD');
        $this->assertFalse($vCardData);

    }
}
