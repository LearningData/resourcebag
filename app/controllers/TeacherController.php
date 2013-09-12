<?php
class TeacherController extends UsersController {
    public function listTeachersAction() {
        $user = $this->getUserBySession();

        if (!$user) {
            return $this->response->redirect("index");
        }

        $this->view->teachers = $user->getTeachers();
    }

    public function newClassAction() {
        $user = $this->getUserBySession();

        $this->view->user = $user;
        $this->view->subjects = Subject::find();
    }

    public function createClassAction() {
        if (!$this->request->isPost()) { return $this->toIndex(); }

        $user = $this->getUserBySession();

        if (!$user) {
            return $this->response->redirect("index");
        }

        $classList = new ClassList();
        $classList->subjectId = $this->request->getPost("subject-id");
        $classList->year = $this->request->getPost("year");
        $classList->extraRef = $this->request->getPost("extra-ref");
        $classList->schyear = $this->request->getPost("schyear");
        $classList->teacherId = $user->id;
        $classList->schoolId = $user->schoolId;

        if(!$classList->save()) {
            foreach ($classList->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(array(
                "controller" => "teacher",
                "action" => "newClass"
            ));
        }

        $this->flash->success("Class was created successfully");
        return $this->dispatcher->forward(array(
                "controller" => "teacher",
                "action" => "index"
        ));
    }
}
?>