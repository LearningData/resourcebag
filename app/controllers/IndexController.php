<?php
use Phalcon\Mvc\View;
require "../app/services/Translation.php";

class IndexController extends Phalcon\Mvc\Controller {
    public function indexAction() {
        if(Authenticate::getUser()) {
            return $this->response->redirect("dashboard");
        }
        $tokenKey = $this->security->getTokenKey();
        $token = $this->security->getToken();

        $this->view->csrf_params = array("name" => $tokenKey, "value" => $token);
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        $this->view->t = Translation::get("en", "schoolbag");
    }
}