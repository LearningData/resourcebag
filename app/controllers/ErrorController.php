<?php
use Phalcon\Mvc\View;

class ErrorController extends \Phalcon\Mvc\Controller {
    public function notFoundAction() {
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }
}

