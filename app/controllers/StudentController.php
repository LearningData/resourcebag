<?php
require "../app/services/Timetable.php";
require "../app/services/ClassListService.php";

class StudentController extends UsersController {
    public function beforeExecuteRoute($dispatcher){
        $user = Authenticate::getUser();

        if(!$user) {
            $this->dispatcher->forward(array(
                "controller" => "index",
                "action" => "index"
            ));
            return false;
        }

        if(!$user->isStudent()) {
            return $this->response->redirect("dashboard");
        }
    }

    public function listClassesAction() {
        $param = "year = " . Config::schoolYear();
        $group = $this->view->user->getGroups($param)->getFirst();
        $this->view->classes = ClassListService::getClassesByGroup($group);
    }

    public function joinClassAction() {
        if ($this->isValidPost()) {
            $classId = $this->request->getPost("class-id");

            if ($classId) {
                $user = $this->view->user;
                $classList = ClassList::findFirstById($classId);
                $classListUser = new ClassListUser();
                $classListUser->schoolId = $user->schoolId;
                $classListUser->studentId = $user->id;
                $classListUser->classId = $classId;

                if ($classListUser->save()) {
                    $slots = TimetableSlot::findByClassId($classId);

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
    }

    public function subjectsAction() {}
    public function calendarAction() {
      return $this->view->pick("student/calendar/index");
    }

    public function listTeachersAction() {
        $user = $this->view->user;
        $school = $user->school;

        $type = User::getTypeTeacher();
        $teachers = $school->getUsers("type = '$type'");
        $this->view->teachers = $teachers;
    }

    public function timetableAction() {
        $user = $this->view->user;
        $slots = array();

        $days = Timetable::getCurrentWeek();

        foreach($days as $day) {
            $dayOfWeek = $day->format("w");
            $slots[$dayOfWeek] = Timetable::getStudentSlotsByDay($user, $day);
        }

        $this->view->period = Timetable::getCurrentWeek();
        $this->view->slots = $slots;
        $this->view->pick("student/timetable/index");
    }
}
?>