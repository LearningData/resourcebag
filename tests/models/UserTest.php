<?php
require 'app/models/User.php';

class UserTest extends PHPUnit_Framework_TestCase {
    function setUp() {
        $this->user = new User();

        $this->user->userID = 1;
        $this->user->FirstName = 'test';
        $this->user->LastName = 'last';
        $this->user->email = "a@b.com";
        $this->user->password = '1234';
        $this->user->schoolID = 1;
        $this->user->Type = 1;
        $this->user->year = 2012;
    }

    function testCorrectEmailFormat() {
        $this->assertTrue($this->user->validation());
    }

    function testRequireEmail() {
        $this->user->email = null;
        $this->assertFalse($this->user->validation());
    }

    function testValidateEmailFormat() {
        $this->user->email = "incorrect";
        $this->assertFalse($this->user->validation());
    }

    function testRequiredNameOk() {
        $this->assertTrue($this->user->validation());
    }

    function testRequiredNameFail() {
        $this->user->FirstName = null;
        $this->assertFalse($this->user->validation());

        $this->user->FirstName = "";
        $this->assertFalse($this->user->validation());

        $this->assertEquals(count($this->user->getMessages()), 2);
    }
}
 ?>