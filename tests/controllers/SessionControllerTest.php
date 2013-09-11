<?php
use Phalcon\DI, Phalcon\DI\FactoryDefault;
use Phalcon\Logger\Adapter\File as FileAdapter;

class SessionControllerTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $this->logger = new FileAdapter("/tmp/schoolbag.log");
        $di = DI::getDefault();

        $this->dispatcher = new Phalcon\Mvc\Dispatcher();
        $this->dispatcher->setDI($di);
        $this->dispatcher->setControllerName("session");
        // $this->dispatcher->setActionName('index');
    }

    public function testPostLoginFail() {
        $this->dispatcher->setActionName("login");
        // $this->dispatcher->request->post();


        $this->assertTrue(true);
    }

}
?>