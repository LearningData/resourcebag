<?php
use Phalcon\Mvc\View;

class IndexController extends Phalcon\Mvc\Controller {
    public function indexAction() {
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }
}

