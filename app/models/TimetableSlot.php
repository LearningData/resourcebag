<?php

class TimetableSlot extends \Phalcon\Mvc\Model {
    public $schoolID;
    public $Day;
    public $timeslotID;
    public $classID;
    public $Room;

    public function getSource() {
        return "timetableslots";
    }

    public static function findByClassAndDay($classId, $day) {
        $query = "classId = " . $classId . " and day = $day";
        $slots = TimetableSlot::find($query);

        return $slots;
    }

    public function columnMap() {
        return array(
            'schoolID' => 'schoolId',
            'Day' => 'day',
            'timeslotID' => 'timeSlotId',
            'classID' => 'classId',
            'Room' => 'room'
        );
    }
}
