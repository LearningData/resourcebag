<?php
use Phalcon\DI, Phalcon\DI\FactoryDefault;
use Phalcon\Logger\Adapter\File as FileAdapter;

require 'app/controllers/UsersController.php';

class UserControllerTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $this->logger = new FileAdapter("/tmp/schoolbag.log");
        $di = DI::getDefault();

        $this->dispatcher = new Phalcon\Mvc\Dispatcher();
        $this->dispatcher->setDI($di);
        $this->dispatcher->setControllerName('users');
        $this->dispatcher->setActionName('index');
    }

    public function testIndex() {
        $response = $this->dispatcher->dispatch();
        $this->assertNotNull($response->view->page);
    }

    public function testCreate() {
        // $this->dispatcher->setActionName('create');
        // $response = $this->dispatcher->dispatch();

        // print_r($this->dispatcher->getReturnedValue());
        // $this->assertNotNull($response->flash);
         $view = new Phalcon\Mvc\View();
         $di = DI::getDefault();
         $view->setDI($di);
         // $view->setViewsDir('app/views/');
         // $view->registerEngines(array(".volt" => "Phalcon\Mvc\View\Engine\Volt"));

         $view->start();
         //Shows recent posts view (app/views/posts/recent.phtml)
         $view->render('contact', 'index');

         //Printing views output
         print_r($view->getContent());
    }
}
 ?>