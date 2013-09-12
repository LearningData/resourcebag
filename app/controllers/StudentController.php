<?php
class StudentController extends UsersController {
    public function listClassesAction() {
        $user = $this->view->user;
        $conditions = "schoolId = ?1 and year = ?2";
        $params = array(1 => $user->schoolId, 2 => $user->year);
        $classes = ClassList::find(array($conditions, "bind" => $params));

        $this->view->classes = $classes;
    }
}
?>