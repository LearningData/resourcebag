<?php
use Phalcon\Mvc\Controller;
require "../app/services/Translation.php";

class ControllerBase extends Controller {
    public function beforeExecuteRoute($dispatcher){
        $user = $this->getUserBySession();

        if(!$user) {
            $this->dispatcher->forward(array(
                "controller" => "index",
                "action" => "index"
            ));
            return false;
        }

        $this->view->user = $user;
        $this->view->t = Translation::get("en", "schoolbag");
    }

    protected function getUserBySession() {
        return Authenticate::getUser();
    }

    protected function setTokenValues() {
        $tokenKey = $this->security->getTokenKey();
        $token = $this->security->getToken();
        $this->view->csrf_params = array("name" => $tokenKey, "value" => $token);
    }

    protected function isValidPost() {
        return ($this->request->isPost() && $this->security->checkToken());
    }

    protected function appendErrorMessages($messages) {
        foreach ($messages as $message) {
            $this->flash->error($message);
        }
    }
}
?>