<?php
class StudentController extends UsersController {
    public function listClassesAction() {
        if ($this->request->get("subject-id")) {
            $subjectId = $this->request->get("subject-id");
        } else {
            $subjectId = 1;
        }
        $user = $this->view->user;
        $classes = $user->school->getClasses("year = " . $user->year . " and subjectId = $subjectId");
        $this->view->classes = $classes;
        $this->view->subjects = Subject::find(array("order" => "name"));
    }

    public function joinClassAction($classId) {
        if ($classId) {
            $classListUser = new ClassListUser();
            $classListUser->schoolId = $this->view->user->schoolId;
            $classListUser->studentId = $this->view->user->id;
            $classListUser->classId = $classId;

            if ($classListUser->save()) {
                $this->flash->success("joined in class");
            } else {
                $this->flash->error("error to save");
            }
        } else {
            $this->flash->error("classId is null");
        }

        $this->dispatcher->forward(array("action" => "index"));
    }

    public function myClassesAction() {}
}
?>