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
    }

    public function listTeachersAction() {
        $teachers = $this->view->user->getTeachers();
        $this->view->teachers = $teachers;
    }

    public function newClassAction() {
        $user = $this->getUserBySession();
        $this->view->subjects = Subject::find();
        $this->view->cohorts = Cohort::findBySchoolId($user->schoolId);

        $slots = array();
        for($i = 1; $i <=6; $i++) {
            $slots[$i] = Timetable::getEmptySlotsByDay($user, $i);
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

        return $this->response->redirect("teacher/subjects");
    }

    public function createClassAction() {
        if (!$this->request->isPost()) { return $this->toIndex(); }

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
                    $this->flash->error("Was not possible to create the slots");

                    return $this->dispatcher->forward(array(
                        "controller" => "teacher",
                        "action" => "newClass"
                    ));
                }
            }
        }

        $this->flash->success("Class was created successfully");
        return $this->response->redirect("teacher/subjects");
    }

    public function newHomeworkAction($classId) {
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

    public function subjectsAction() {
        $teacherId = $this->view->user->id;
        $this->view->classes = ClassList::find("teacherId = $teacherId");
        $this->view->pick("teacher/subject/index");
    }

    public function createHomeworkAction() {
        if (!$this->request->isPost()) { return $this->toIndex(); }
        $classListId = $this->request->getPost("class-id");
        $classList = ClassList::findFirstById($classListId);
        $forAll = $this->request->getPost("all");

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

        foreach ($students as $student) {
            $params = $this->request->getPost();
            $homework = HomeworkService::create($student, $classList, $params);

            if (!$homework->save()) {
                $this->flash->error("Error to save homework for student: " .
                    $student->id);
                foreach ($homework->getMessages() as $message) {
                    $this->flash->error($message);
                }

                return $this->response->redirect("teacher/subjects");
            }
        }

        $this->flash->success("Homework created");
        return $this->response->redirect("teacher/homework");
    }

    public function showClassAction($classId) {
        $this->view->classList = ClassList::findFirstById($classId);
    }
}
?>