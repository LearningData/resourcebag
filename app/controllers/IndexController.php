<?php
use Phalcon\Mvc\View;

class IndexController extends Phalcon\Mvc\Controller {
    public function indexAction() {
        if(Authenticate::getUser()) {
            return $this->response->redirect("dashboard");
        }
        $tokenKey = $this->security->getTokenKey();
        $token = $this->security->getToken();

        $this->view->csrf_params = array("name" => $tokenKey, "value" => $token);
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }
}