<?php
require "../app/services/Timetable.php";

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
        $this->view->schoolYear = Config::findFirst("name = 'schoolYear'");
        $slots = array();
        for($i = 2; $i <=7; $i++) {
            $slots[$i] = Timetable::getEmptySlotsByDay($this->view->user, $i);
        }
        $this->view->slots = $slots;
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
                "action" => "listClasses"
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

        for($i=2; $i <= 7; $i++){
            $slots = $this->request->getPost("day$i");
            foreach ($slots as $slotId) {
                $slot = new TimetableSlot();
                $slot->timeSlotId = $slotId;
                $slot->schoolId = $this->view->user->schoolId;
                $slot->day = $i;
                $slot->classId = $classList->id;
                $slot->room = "hack room";

                if (!$slot->save()) {
                    $this->flash->error("Was not possible to create the slots");

                    return $this->dispatcher->forward(array(
                        "controller" => "teacher",
                        "action" => "newClass"
                    ));
                }
            }
        }

        $this->flash->success("Class was created successfully");
        return $this->dispatcher->forward(array(
                "controller" => "teacher",
                "action" => "index"
        ));
    }

    public function timetableAction() {
        $user = $this->view->user;
        $slots = array();

        for($i=2; $i <= 7; $i++) {
            $slots[$i] = Timetable::getSlotsByDay($user, $i);
        }
        $this->view->slots = $slots;
        $this->view->render("teacher/timetable", "index");
    }
}
?>