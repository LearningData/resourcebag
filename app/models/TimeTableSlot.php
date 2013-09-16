<?php

class TimeTableSlot extends \Phalcon\Mvc\Model {
    public $schoolID;
    public $Day;
    public $timeslotID;
    public $classID;
    public $Room;

    public function getSource() {
        return "timetableslots";
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
