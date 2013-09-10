<?php
class StudentController extends ControllerBase {
    public function indexAction() {
        $userId = $this->session->get("userId");
        if(!$userId) {
            return $this->response->redirect("index");
        }

        $user = User::findFirst($userId);
        $this->view->user = $user;
    }
}
?>