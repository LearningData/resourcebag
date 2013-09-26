<?php

class ServiceController extends ControllerBase {
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
}