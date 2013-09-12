<?php
class TeacherController extends UsersController {
    public function listTeachersAction() {
        $teachers = $this->view->user->getTeachers();
        $this->view->teachers = $teachers;
    }

    public function listClassesAction() {
        $teacherId = $this->view->user->id;
        $this->view->classes = ClassList::find("teacherId = $teacherId");
    }

    public function newClassAction() {
        $this->view->subjects = Subject::find();
    }

    public function deleteClassAction($classId) {
        $classList = ClassList::findFirstById($classId);

        if (!$classList) {
            $this->flash->error("school was not found");
            return $this->toIndex();
        }

        if (!$classList->delete()) {
            foreach ($classList->getMessages() as $message){
                $this->flash->error($message);
            }

            return $this->toIndex();
        }

        $this->flash->success("Class was deleted successfully");

        return $this->dispatcher->forward(array(
                "action" => "listClass"
        ));
    }

    public function createClassAction() {
        if (!$this->request->isPost()) { return $this->toIndex(); }

        $classList = new ClassList();
        $classList->subjectId = $this->request->getPost("subject-id");
        $classList->year = $this->request->getPost("year");
        $classList->extraRef = $this->request->getPost("extra-ref");
        $classList->schyear = $this->request->getPost("schyear");
        $classList->teacherId = $this->view->user->id;
        $classList->schoolId = $this->view->user->schoolId;

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