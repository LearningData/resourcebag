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
        return $this->dispatcher->forward(array(
                "controller" => "teacher",
                "action" => "index"
        ));
    }

    public function timetableAction() {
        $user = $this->view->user;
        $slots = array();

        for($i=1; $i <= 6; $i++) {
            $slots[$i] = Timetable::getSlotsByDay($user, $i);
        }
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

        foreach ($students as $studentId) {
            $homework = new Homework();
            $homework->text = $this->request->getPost("description");
            $homework->classId = $this->request->getPost("class-id");
            $homework->dueDate = $this->request->getPost("due-date");
            $homework->schoolId = $this->view->user->schoolId;
            $homework->teacherId = $this->view->user->id;
            $homework->studentId = $studentId;
            $homework->timeSlotId = "0000";
            $homework->setDate = date("Y-m-d");
            $homework->submittedDate = "0000-00-00";
            $homework->reviewedDate = "0000-00-00";
            $homework->status = 0;

            if (!$homework->save()) {
                $this->flash->error("Error to save homework for student: $studentId");
                foreach ($homework->getMessages() as $message) {
                    $this->flash->error($message);
                }
            }
        }

        $this->flash->success("Homework created");
        return $this->response->redirect("student/homework/" . $homework->classId);
    }
}
?>