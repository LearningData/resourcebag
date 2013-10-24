<?php
require 'app/services/Authenticate.php';

class AuthenticateServiceTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $this->email = "test@unittest.com";
        $this->password = "1234";
        $this->user = new User();

        $this->user->name = 'test';
        $this->user->lastName = 'last';
        $this->user->email = $this->email;
        $this->user->password = $this->password;
        $this->user->year = 1;
        $this->user->schoolId = 1;
        $this->user->type = 1;
        $this->user->id = 1;

        $this->user->save();

    }

    public function tearDown() {
        $this->user->delete();
    }

    public function testAuthenticationSuccess() {
        // $user = Authenticate::authentication($this->email, $this->password);
        // $this->assertNotNull($user);

        // $this->assertEquals($user->email, $this->email);
        $this->markTestIncomplete('This test has not been implemented yet.');
    }

    public function testAuthenticationFail() {
        $user = Authenticate::authentication("invalid", "password");
        $this->assertFalse($user);
    }
}
?>