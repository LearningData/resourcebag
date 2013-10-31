<?php
use Phalcon\Mvc\Controller;

class ControllerBase extends Controller {
    public function beforeExecuteRoute($dispatcher){
        $user = $this->getUserBySession();

        if (!$user) {
            $this->response->redirect("index");
            return false;
        }

        $this->view->user = $user;
        // $cname = $dispatcher->getControllerName();

        // if ($cname != $user->getController()) {
        //     $this->response->redirect($user->getController());
        //     return false;
        // }
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