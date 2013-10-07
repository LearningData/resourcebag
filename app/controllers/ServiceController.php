<?php

class ServiceController extends ControllerBase {
    public function homeworksAction($userId) {
        $homeworks = Homework::find("studentId = $userId");

        $jsonHomeworks = array();

        foreach ($homeworks as $homework) {
            $subject = $homework->classList->subject->name;
            $jsonHomeworks []= array("id" => $homework->id,
                 "subject" => $subject,
                 "description" => $homework->text
            );
        }

        $response = new Phalcon\Http\Response();
        $content = array('status' => 'success', 'homeworks' => $jsonHomeworks);

        header('Content-Type: application/json');

        $response->setJsonContent($content);

        return $response;
    }

    public function daysByClassAction($classId) {
        $slots = TimetableSlot::find("classId = " . $classId);

        $weekDays = "";

        foreach ($slots as $slot) { $weekDays .= $slot->day . ","; }

        $response = new Phalcon\Http\Response();
        $content = array('status' => 'success', 'weekDays' => $weekDays);

        header('Content-Type: application/json');

        $response->setJsonContent($content);

        return $response;
    }

    public function getClassTimesAction($classId, $day) {
        $query = "classId = $classId and day = $day";

        $times = array();
        $slots = TimetableSlot::find($query);
        foreach ($slots as $slot) { array_push($times, $slot->timeSlotId); }
        $response = new Phalcon\Http\Response();

        header('Content-Type: application/json');
        $response->setJsonContent(array("times" => $times));

        return $response;
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

        $response = new Phalcon\Http\Response();

        header('Content-Type: application/json');
        $response->setJsonContent(array("students" => $students));

        return $response;
     }
}