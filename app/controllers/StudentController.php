<?php
class StudentController extends UsersController {
    public function listClassesAction() {
        $user = $this->view->user;
        $classes = $user->school->getClasses("year = " . $user->year);

        $this->view->classes = $classes;
    }
}
?>