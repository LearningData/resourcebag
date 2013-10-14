<?php

class ServiceController extends ControllerBase {
    public function homeworksAction() {
        $user = $this->getUserBySession();
        $homeworks = Homework::find("studentId = " . $user->id);

        $jsonHomeworks = array();

        foreach ($homeworks as $homework) {
            $subject = $homework->classList->subject->name;
            $jsonHomeworks []= array("id" => $homework->id,
                 "subject" => $subject,
                 "description" => $homework->text,
                 "status" => $homework->status,
            );
        }

        $content = array('status' => 'success', 'homeworks' => $jsonHomeworks);

        return $this->setContent($content);
    }

    public function classesAction() {
        $user = $this->getUserBySession();
        $json = array();

        foreach ($user->classes as $classList) {
            $json []= array("id" => $classList->id,
                "subject" => $classList->subject->name);
        }

        return $this->setContent(array("classes" => $json));
    }

    public function daysByClassAction($classId) {
        $slots = TimetableSlot::find("classId = " . $classId);
        $weekDays = "";

        foreach ($slots as $slot) { $weekDays .= $slot->day . ","; }

        $content = array('status' => 'success', 'weekDays' => $weekDays);

        return $this->setContent($content);
    }

    public function getClassTimesAction($classId, $day) {
        $query = "classId = $classId and day = $day";
        $times = array();
        $slots = TimetableSlot::find($query);

        foreach ($slots as $slot) { array_push($times, $slot->timeSlotId); }

        return $this->setContent(array("times" => $times));
    }

    public function getStudentsAction($classId) {
        $classList = ClassList::findFirstById($classId);
        $users = $classList->users;
        $students = array();

        foreach($users as $user) {
            $students []= array(
                "id" => $user->id,
                "name" => $user->name . " " . $user->lastName
            );
        }

        return $this->setContent(array("students" => $students));
     }

     public function timetableAction() {
        $user = $this->getUserBySession();
        $slots = array();

        $days = Timetable::getCurrentWeek();

        foreach($days as $day) {
            $dayOfWeek = $day->format("w");
            $slots[$dayOfWeek] = Timetable::getStudentSlotsByDay($user, $day);
        }

        return $this->setContent(array("week" => $slots));
     }

     public function calendarAction() {
        $user = $this->getUserBySession();

        return $this->setContent($user->events->toArray());
     }

     private function setContent($content) {
        header('Content-Type: application/json');
        $response = new Phalcon\Http\Response();
        $response->setJsonContent($content);

        return $response;
     }
}