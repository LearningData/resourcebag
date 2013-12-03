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

    public function createOrUpdateSlots($slotIds, $classList, $day, $room) {
        foreach ($classList->getSlots("day = $day") as $slot) {
            if(!in_array($slot->timeSlotId, $slotIds)) {
                $slot->delete();
            } else {
                $slot->room = $room;
                $slot->save();
            }
        }

        $ids = $classList->getSlotIdsByDay($day);

        foreach($slotIds as $slotId) {
            if(in_array($slotId, $ids)) { continue; }

            $slot = new TimetableSlot();
            $slot->timeSlotId = $slotId;
            $slot->schoolId = $classList->schoolId;
            $slot->day = $day;
            $slot->classId = $classList->id;
            $slot->room = $room;
            $slot->save();
        }
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
