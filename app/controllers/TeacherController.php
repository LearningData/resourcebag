<?php
require "../app/services/Timetable.php";

class TeacherController extends UsersController {
    public function listTeachersAction() {
        $teachers = $this->view->user->getTeachers();
        $this->view->teachers = $teachers;
    }

    public function newClassAction() {
        $this->view->subjects = Subject::find();
        $this->view->schoolYear = Config::findFirst("name = 'schoolYear'");
        $slots = array();
        for($i = 1; $i <=6; $i++) {
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

        return $this->response->redirect("teacher/subjects");
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

        $students = $this->request->getPost("students");

        if(!$students) { return $this->toIndex(); }
        $classListId = $this->request->getPost("class-id");
        $classList = ClassList::findFirstById($classListId);

        foreach ($students as $studentId) {
            $student = User::findFirstById($studentId);
            $params = $this->request->getPost();
            $homework = HomeworkService::create($student, $classList, $params);

            if (!$homework->save()) {
                $this->flash->error("Error to save homework for student: $studentId");
                foreach ($homework->getMessages() as $message) {
                    $this->flash->error($message);
                }
            }
        }

        $this->flash->success("Homework created");
        return $this->response->redirect("teacher/homework");
    }
}
?>