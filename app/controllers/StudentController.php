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
}
?>