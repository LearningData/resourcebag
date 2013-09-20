<?php
use Phalcon\Mvc\Controller;

class ControllerBase extends Controller {
    protected function getUserBySession() {
        $userId = $this->session->get("userId");
        $user = User::findFirstById($userId);
        if ($user) { $this->view->user = $user; }

        return $user;
    }
}
?>