<?php

class TimetableSlot extends \Phalcon\Mvc\Model {
    public $schoolID;
    public $Day;
    public $timeslotID;
    public $classID;
    public $Room;
    public $id;

    public function initialize() {
        $this->belongsTo("classId", "ClassList", "id");
    }

    public function getSource() {
        return "timetableslots";
    }

    public static function findByClassAndDay($classId, $day) {
        $query = "classId = ?1 and day = ?2";
        $params = array($query, "bind" => array(1 => $classId, 2 => $day));

        return TimetableSlot::find($params);
    }

    public function columnMap() {
        return array(
            'schoolID' => 'schoolId',
            'Day' => 'day',
            'timeslotID' => 'timeSlotId',
            'classID' => 'classId',
            'Room' => 'room',
            'id' => 'id'
        );
    }
}
