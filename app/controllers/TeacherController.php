<?php
class TeacherController extends UsersController {
    public function indexAction() {
        $userId = $this->session->get("userId");
        if(!$userId) {
            return $this->response->redirect("index");
        }

        $user = User::findFirst($userId);
        $this->view->user = $user;

        echo "Teacher Page: " . $user->name . " " . $user->lastName;
    }

    public function changePasswordAction($userId) {
        $this->view->userId = $userId;
    }
}
?>