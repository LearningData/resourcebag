<?php

class TimetableChange extends \Phalcon\Mvc\Model {
    public $schoolID;
    public $Day;
    public $timeslotID;
    public $studentID;
    public $Room;
    public $subjectID;

    public function initialize() {
        $this->belongsTo("subjectId", "Subject", "id");
    }

    public function getSource() {
        return "timetablechanges";
    }

    public function createOrUpdateSlots($slotIds, $classList, $day, $room) {
        foreach($classList->users as $student) {
            $slots = TimetableChange::find("day = $day and studentId = " .
                $student->id . " and subjectId = " . $classList->subject->id);

            $ids = array();

            foreach ($slots as $slot) {
                $ids []= $slot->timeSlotId;
            }

            foreach($slots as $slot) {
                if(!in_array($slot->timeSlotId, $slotIds)) {
                    $slot->delete();
                } else {
                    $slot->room = $room;
                    $slot->save();
                }
            }

            foreach($slotIds as $slotId) {
                if(in_array($slotId, $ids)) { continue; }

                $slot = new TimetableChange();
                $slot->timeSlotId = $slotId;
                $slot->schoolId = $classList->schoolId;
                $slot->studentId = $student->id;
                $slot->day = $day;
                $slot->subjectId = $classList->subject->id;
                $slot->room = $room;

                $slot->save();
            }
        }
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
