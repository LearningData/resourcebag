<?php
require "../app/services/Timetable.php";

class TeacherController extends UsersController {
    public function beforeExecuteRoute($dispatcher){
        $user = Authenticate::getUser();

        if(!$user) {
            $this->dispatcher->forward(array(
                "controller" => "index",
                "action" => "index"
            ));
            return false;
        }

        if(!$user->isTeacher()) {
            return $this->response->redirect("dashboard");
        }

        $this->view->t = Translation::get(Language::get(), "schoolbag");
    }

    public function listTeachersAction() {
        $teachers = $this->view->user->getTeachers();
        $this->view->teachers = $teachers;
    }

    public function newClassAction() {
        $user = $this->getUserBySession();
        $this->view->subjects = Subject::find();
        $this->view->cohorts = Cohort::findBySchoolId($user->schoolId);
        $this->view->t = Translation::get(Language::get(), "classes");
        $this->view->classList = new ClassList();
        $this->view->classList->id = 0;
        $this->view->action = "new";

        $slots = array();
        for($i = 1; $i <=6; $i++) {
            $slots[$i] = Timetable::getEmptySlotsByDay($user, $i);
        }
        $this->view->slots = $slots;
    }

    public function editClassAction($classId) {
        $this->view->t = Translation::get(Language::get(), "classes");
        $user = $this->getUserBySession();

        $classList = ClassList::findFirstById($classId);
        $this->tag->setDefault("subject-id", $classList->subject->id);
        $this->tag->setDefault("cohort-id", $classList->cohort->id);
        $this->view->subjects = Subject::find();
        $this->view->cohorts = Cohort::findBySchoolId($user->schoolId);
        $this->view->classList = $classList;

        if(count($classList->slots) > 0) {
            $this->view->room = $classList->slots[0]->room;
        } else {
            $this->view->room = "";
        }

        $slots = array();

        for($i = 1; $i <=6; $i++) {
            $slots[$i] = Timetable::getTeacherTimetable($user, $i, $classId);
        }

        $this->view->slots = $slots;
    }

    public function deleteClassAction($classId) {
        $classList = ClassList::findFirstById($classId);
        $t = Translation::get(Language::get(), "classes");

        if (!$classList) {
            $this->flash->error($t->_("class-not-found"));
            return $this->toIndex();
        }

        if (!$classList->delete()) {
            foreach ($classList->getMessages() as $message){
                $this->flash->error($message);
            }

            return $this->toIndex();
        }

        $this->flash->success($t->_("class-deleted"));

        return $this->response->redirect("teacher/classes");
    }

    public function updateClassAction() {
        if (!$this->request->isPost()) { return $this->toIndex(); }
        $t = Translation::get(Language::get(), "classes");

        $classList = ClassList::findFirstById($this->request->getPost("class-id"));
        $classList->extraRef = $this->request->getPost("extra-ref");
        $room = $this->request->getPost("room");

        if(!$room) {
            if(count($classList->slots) > 0) {
                $room = $classList->slots[0]->room;
            } else {
                $room = "";
            }
        }

        if(!$classList->save()) {
            foreach ($classList->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "teacher",
                "action" => "newClass"
            ));
        }

        for($day=1; $day <= 6; $day++){
            $slotIds = $this->request->getPost("day$day");

            if (!$slotIds) { continue; }

            TimetableSlot::createOrUpdateSlots($slotIds, $classList, $day, $room);
            TimetableChange::createOrUpdateSlots($slotIds, $classList, $day, $room);

            // foreach($classList->users as $student) {
            //     $slots = TimetableChange::find("day = $day and studentId = " .
            //         $student->id . " and subjectId = " . $classList->subject->id);

            //     foreach($slots as $slotId) {
            //         if(!in_array($slot->timeSlotId, $slotIds)) {
            //             $slot->delete();
            //         } else {
            //             $slot->room = $room;
            //             $slot->save();
            //         }
            //     }
            // }
        }

        $this->flash->success($t->_("class-updated"));
        return $this->response->redirect("teacher/classes");
    }

    public function createClassAction() {
        if (!$this->request->isPost()) { return $this->toIndex(); }
        $t = Translation::get(Language::get(), "classes");

        $classList = new ClassList();
        $classList->subjectId = $this->request->getPost("subject-id");
        $classList->cohortId = $this->request->getPost("cohort-id");
        $classList->extraRef = $this->request->getPost("extra-ref");
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

        for($i=1; $i <= 6; $i++){
            $slots = $this->request->getPost("day$i");
            if (!$slots) { continue; }

            foreach ($slots as $slotId) {
                $slot = new TimetableSlot();
                $slot->timeSlotId = $slotId;
                $slot->schoolId = $this->view->user->schoolId;
                $slot->day = $i;
                $slot->classId = $classList->id;
                $slot->room = $this->request->getPost("room");

                if (!$slot->save()) {
                    $this->flash->error($t->_("slot-not-saved"));

                    return $this->dispatcher->forward(array(
                        "controller" => "teacher",
                        "action" => "newClass"
                    ));
                }
            }
        }

        $this->flash->success($t->_("class-created"));
        return $this->response->redirect("teacher/classes");
    }

    public function newHomeworkAction($classId) {
        $this->view->t = Translation::get(Language::get(), "homework");
        $this->view->classList = ClassList::findFirstById($classId);
        $slots = TimetableSlot::find("classId = " . $classId);
        $weekDays = "";

        foreach ($slots as $slot) { $weekDays .= $slot->day . ","; }

        $this->view->weekDays = $weekDays;
        $this->view->pick("teacher/homework/new");
    }

    public function timetableAction() {
        $user = $this->view->user;
        $slots = array();

        $days = Timetable::getCurrentWeek();

        foreach($days as $day) {
            $dayOfWeek = $day->format("w");
            $slots[$dayOfWeek] = Timetable::getTeacherSlotsByDay($user, $day);
        }

        $this->view->period = Timetable::getCurrentWeek();
        $this->view->slots = $slots;
        $this->view->pick("teacher/timetable/index");
    }

    public function classesAction() {
        $teacherId = $this->view->user->id;
        $this->view->t = Translation::get(Language::get(), "classes");
        $this->view->classes = ClassList::find(array(
            "order" => "subjectId",
            "teacherId = $teacherId"));
        $this->view->pick("teacher/subject/index");
    }

    public function createHomeworkAction() {
        if (!$this->request->isPost()) { return $this->toIndex(); }
        $classListId = $this->request->getPost("class-id");
        $classList = ClassList::findFirstById($classListId);
        $forAll = $this->request->getPost("all");
        $user = Authenticate::getUser();

        if($forAll) {
            $students = $classList->users;
        } else {
            $studentsId = $this->request->getPost("students");
            if(!$studentsId) { return $this->toIndex(); }
            $students = array();

            foreach ($studentsId as $studentId) {
                $students []= User::findFirstById($studentId);
            }
        }

        $params = $this->request->getPost();
        $homework = HomeworkService::create($classList, $params, $user->id);

        if (!$homework->save()) {
            $this->flash->error("Error to create homework:");
            foreach ($homework->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->response->redirect("teacher/classes");
        }

        foreach ($students as $student) {
            $homeworkUser = HomeworkService::createHomeworkUser($homework->id,
                $student->id);

            if (!$homeworkUser->save()) {
                $this->flash->error("Error to save homework for student: " .
                    $student->id);
                foreach ($homework->getMessages() as $message) {
                    $this->flash->error($message);
                }

                // return $this->response->redirect("teacher/classes");
            }
        }

        $this->flash->success("Homework created");
        return $this->response->redirect("teacher/classes");
    }

    public function showClassAction($classId) {
        $this->view->t = Translation::get(Language::get(), "classes");
        $this->view->classList = ClassList::findFirstById($classId);
    }

    public function createSlotAction() {
        $classId = $this->request->getPost("class-id");
        $classList = ClassList::findFirstById($classId);

        if($classList) {
            $day = $this->request->getPost("day");
            $schoolId = $this->request->getPost("school-id");
            $timeSlotId = $this->request->getPost("slot-id");
            $room = $this->request->getPost("room");

            $slot = new TimetableSlot();
            $slot->timeSlotId = $timeSlotId;
            $slot->room = $room;
            $slot->classId = $classList->id;
            $slot->schoolId = $schoolId;
            $slot->day = $day;

            $slot->save();
        }

        return $this->response->redirect("teacher/timetable");
    }
}
?>
