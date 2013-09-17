<?php


class TimetableChange extends \Phalcon\Mvc\Model {
    public $schoolID;
    public $Day;
    public $timeslotID;
    public $studentID;
    public $Room;
    public $subjectID;


    public function getSource() {
        return "timetablechanges";
    }

    public function columnMap() {
        return array(
            'schoolID' => 'schoolId',
            'Day' => 'day',
            'timeslotID' => 'timeSlotId',
            'studentID' => 'studentId',
            'Room' => 'room',
            'subjectID' => 'subjectId'
        );
    }
}
