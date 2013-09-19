<?php
use Phalcon\Mvc\Controller;

class ControllerBase extends Controller {
    protected function getUserBySession() {
        $userId = $this->session->get("userId");
        $user = User::findFirstById($userId);
        $this->view->user = $user;

        return $user;
    }
}
?>