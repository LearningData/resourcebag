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
        $userId = $this->session->get("userId");
        $user = User::findFirstById($userId);
        if ($user) { $this->view->user = $user; }

        return $user;
    }

    protected function appendErrorMessages($messages) {
        foreach ($messages as $message) {
            $this->flash->error($message);
        }
    }
}
?>