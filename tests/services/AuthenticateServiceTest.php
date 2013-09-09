<?php
require 'app/services/Authenticate.php';

class AuthenticateServiceTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $this->email = "test@unittest.com";
        $this->password = "1234";
        $this->user = new User();

        $this->user->FirstName = 'test';
        $this->user->LastName = 'last';
        $this->user->email = $this->email;
        $this->user->password = $this->password;
        $this->user->schoolID = 1;
        $this->user->Type = 1;
        $this->user->year = 2012;

        $this->user->save();
    }

    public function tearDown() {
        $this->user->delete();
    }

    public function testAuthenticationSuccess() {
        $user = Authenticate::authentication($this->email, $this->password);
        $this->assertNotNull($user);

        $this->assertEquals($user->email, $this->email);
    }

    public function testAuthenticationFail() {
        $user = Authenticate::authentication("invalid", "password");
        $this->assertFalse($user);
    }
}
?>