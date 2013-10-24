<?php
use Phalcon\Mvc\View;

class IndexController extends Phalcon\Mvc\Controller {
    public function indexAction() {
        if(Authenticate::getUser()) {
            return $this->response->redirect("dashboard");
        }

        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }
}

