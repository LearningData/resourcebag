<?php
class TeacherController extends UsersController {
    public function listTeachersAction() {
        $userId = $this->session->get("userId");
        $user = User::findFirstById($userId);
        if (!$user) {
            return $this->response->redirect("index");
        }

        $this->view->teachers = $user->getTeachers();
    }
}
?>