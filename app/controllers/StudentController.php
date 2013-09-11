<?php
class StudentController extends UsersController {
    public function indexAction() {
        $userId = $this->session->get("userId");
        if(!$userId) {
            return $this->response->redirect("index");
        }

        $user = User::findFirst($userId);
        $this->view->user = $user;
    }

    public function changePasswordAction($userId) {
        $this->view->userId = $userId;
        $this->tag->setDefault("user-id", $userId);
    }
}
?>