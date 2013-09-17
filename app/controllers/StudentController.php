<?php
require "../app/services/Timetable.php";

class StudentController extends UsersController {
    public function listClassesAction() {
        if ($this->request->get("subject-id")) {
            $subjectId = $this->request->get("subject-id");
        } else {
            $subjectId = 1;
        }
        $user = $this->view->user;
        $params = "year = " . $user->year . " and subjectId = $subjectId";
        $classes = $user->school->getClasses($params);
        $this->view->classes = $classes;
        $this->view->subjects = Subject::find(array("order" => "name"));
    }

    public function joinClassAction($classId) {
        if ($classId) {
            $user = $this->view->user;
            $classList = ClassList::findFirstById($classId);
            $classListUser = new ClassListUser();
            $classListUser->schoolId = $user->schoolId;
            $classListUser->studentId = $user->id;
            $classListUser->classId = $classId;

            if ($classListUser->save()) {
                $slots = TimetableSlot::find("classId = $classId");

                foreach ($slots as $slot) {
                    $timetableChange = new TimetableChange();
                    $timetableChange->schoolId = $slot->schoolId;
                    $timetableChange->day = $slot->day;
                    $timetableChange->studentId = $user->id;
                    $timetableChange->timeSlotId = $slot->timeSlotId;
                    $timetableChange->room = $slot->room;
                    $timetableChange->subjectId = $classList->subject->id;

                    if (!$timetableChange->save()) {
                        $classListUser->delete();
                        $this->flash->error("was not possible join in class");
                        $this->dispatcher->forward(array("action" => "index"));
                    }
                }

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

    public function listTeachersAction() {
        $user = $this->view->user;
        $school = $user->school;

        $type = User::getTypeTeacher();
        $teachers = $school->getUsers("type = '$type' and year = " . $user->year);
        $this->view->teachers = $teachers;
    }

    public function timetableAction() {
        $user = $this->view->user;
        $slots = array();

        for($i=2; $i <= 7; $i++) {
            $slots[$i] = Timetable::getStudentSlotsByDay($user, $i);
        }
        $this->view->slots = $slots;
        $this->view->render("student/timetable", "index");
    }
}
?>