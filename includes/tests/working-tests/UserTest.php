<?php

require_once __DIR__ . '/../../classes/User.php';
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
        $instance = new User(true);
        // when
        $password = 'brzydkieHaslo';
        $instance->setPassword($password);
        // then
        $this->assertNotEquals($instance->pass, $password);

    }

    public function testLoginCorrectUser()
    {
        //given
        $permission = 2;
        $instance = new User(true);
        $DAO = $this->getMock('UserDAO');
        $DAO->expects($this->any())->method('autorization')->will($this->returnValue($permission));

        //when
        $instance->login('testUserName', $DAO);
        //then
        $this->assertEquals($instance->logged,true);
        $this->assertEquals($instance->permissions, $permission);
    }

    public function testClearPasswordAfterSuccessLogin()
    {
        //given
        $instance = new User(true);
        $instance->setPassword('zzzz');
        $DAO = $this->getMock('UserDAO');
        $DAO->expects($this->any())->method('autorization')->will($this->returnValue(2));
        //when
        $instance->login('aaa', $DAO);
        //then
        $this->assertNull($instance->pass);
    }

    public function testClearPassworAfterFailedLogin()
    {
        $instance = new User(true);
        $instance->setPassword('zzzz');
        $DAO = $this->getMock('UserDAO');
        $DAO->expects($this->any())->method('autorization')->will($this->returnValue(null));

        $instance->login('bbbb', $DAO);

        $this->assertNull($instance->pass);

    }


}