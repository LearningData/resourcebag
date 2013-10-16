<?php
use Phalcon\Mvc\View;

class IndexController extends Phalcon\Mvc\Controller {
    public function indexAction() {
        $user = $this->getUserBySession();
        if($user) {
            return $this->response->redirect("dashboard");
        }
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
    }

    protected function getUserBySession() {
        $userId = $this->session->get("userId");
        $user = User::findFirstById($userId);
        if ($user) { $this->view->user = $user; }

        return $user;
    }
}

