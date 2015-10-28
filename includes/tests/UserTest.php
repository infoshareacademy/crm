<?php

require_once __DIR__ . '/../classes/User.php';
/**
 * Created by PhpStorm.
 * User: katban
 * Date: 22.10.15
 * Time: 16:05
 */
class userTest extends PHPUnit_Framework_TestCase
{

    public function testPasswordEncoding()
    {
        // given
        $instance = new User(null,null,null,true);
        // when
        $password = 'brzydkieHaslo';
        $instance->setPassword($password);
        // then
        $this->assertNotEquals($instance->pass, $password);

    }
}