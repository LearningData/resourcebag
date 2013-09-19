<?php
require 'app/models/User.php';

class UserTest extends PHPUnit_Framework_TestCase {
    function setUp() {
        $this->user = new User();

        $this->user->id = 1;
        $this->user->name = 'test';
        $this->user->lastName = 'last';
        $this->user->email = "a@b.com";
        $this->user->password = '1234';
        $this->user->schoolId = 1;
        $this->user->type = 1;
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
        $this->user->name = null;
        $this->assertFalse($this->user->validation());

        $this->user->name = "";
        $this->assertFalse($this->user->validation());

        $this->assertEquals(count($this->user->getMessages()), 2);
    }

    function testGetControllerAdmin() {
        $this->user->type = "A";
        $this->assertEquals("admin", $this->user->getController());
    }

    function testGetControllerTeacher() {
        $this->user->type = "T";
        $this->assertEquals("teacher", $this->user->getController());
    }

    function testGetControllerPupil() {
        $this->user->type = "S";
        $this->assertEquals("school", $this->user->getController());
    }

    function testGetControllerStudent() {
        $this->user->type = "P";
        $this->assertEquals("student", $this->user->getController());
    }

    function testUserIsStudent() {
        $this->user->type = User::getTypeStudent();
        $this->assertTrue($this->user->isStudent());
    }
}
 ?>