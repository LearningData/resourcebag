<?php
use Phalcon\Session\Adapter\Files as SessionAdapter;
require 'app/services/Authenticate.php';
require 'app/models/SuccessLogin.php';
require 'app/models/FailedLogin.php';

class AuthenticateServiceTest extends PHPUnit_Framework_TestCase {
    public $di;
    public $session;
    public $request;

    public function setUp() {
        $this->email = "test@unittest.com";
        $this->password = "1234";
        $this->user = new User();

        $this->user->name = 'test';
        $this->user->username = 'usertest';
        $this->user->lastName = 'last';
        $this->user->email = $this->email;
        $this->user->password = md5($this->password);
        $this->user->year = 1;
        $this->user->schoolId = 1;
        $this->user->type = 1;
        $this->user->id = 1;

        $this->user->save();

        $this->session = new SessionAdapter();
        $this->request = new Phalcon\Http\Request();
    }

    public function tearDown() {
        $this->user->delete();
    }

    public function testAuthenticationByEmailSuccess() {
        $user = Authenticate::authentication($this->email, $this->password);
        $this->assertNotNull($user);
        $this->assertEquals($user->email, $this->email);
    }

    public function testAuthenticationByUsernameSuccess() {
        $user = Authenticate::authentication($this->user->username,
            $this->password);
        $this->assertNotNull($user);
        $this->assertEquals($user->email, $this->email);
    }

    public function testAuthenticationValidUsernameFail() {
        $user = Authenticate::authentication($this->user->username,
            "invalid");
        $this->assertFalse($user);
    }

    public function testAuthenticationValidEmailFail() {
        $user = Authenticate::authentication($this->user->email,
            "invalid");
        $this->assertFalse($user);
    }

    public function testCheckPassowrdTrue() {
        $this->assertTrue(Authenticate::checkPassword($this->password,
            $this->user->password));
    }
}
?>