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
        $this->view->schoolYear = Config::findFirst("name = 'schoolYear'");
        $this->view->mondaySlots = TimeTableConfig::find("schoolId = " . $this->view->user->schoolId . " and weekDay = 2");
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

        $monday = $this->request->getPost("monday");

        foreach ($monday as $slotId) {
            $slot = new TimeTableSlot();
            $slot->timeSlotId = $slotId;
            $slot->schoolId = $this->view->user->schoolId;
            $slot->day = 2;
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

        $this->flash->success("Class was created successfully");
        return $this->dispatcher->forward(array(
                "controller" => "teacher",
                "action" => "index"
        ));
    }

    public function timetableAction() {
        $schoolId = $this->view->user->schoolId;
        $params = "schoolId = $schoolId and weekDay = 2";
        $mondaySlots = TimeTableConfig::find($params);
        $this->view->myHash = array('first' => 1, 'second' => 2);

        $user = $this->view->user;
        $this->view->classes = ClassList::find("teacherId = " . $user->id);
        $slots = array();

        foreach ($this->view->classes as $classList) {
            $query = "classId = " . $classList->id;
            $slot = TimeTableSlot::findFirst($query);
            if ($slot) {
                $slots[$slot->timeSlotId] = $classList->subject->name;
            }
        }

        $monday = array();

        foreach ($mondaySlots as $mondaySlot) {
            if (array_key_exists($mondaySlot->id, $slots)) {
                $subjectName = $slots[$mondaySlot->id];
                $monday[$mondaySlot->id] = $mondaySlot->startTime . " / " . $subjectName;
            } else {
                $monday[$mondaySlot->id] = $mondaySlot->startTime;
            }
        }

        $this->view->slots = $monday;
        $this->view->render("teacher/timetable", "index");
    }
}
?>