<?php

class ClassList extends \Phalcon\Mvc\Model {

    public $schoolID;
    public $classID;
    public $subjectID;
    public $extraRef;
    public $teacherID;
    public $cohortId;

    public function initialize() {
        $this->belongsTo("subjectId", "Subject", "id");
        $this->belongsTo("schoolId", "School", "id");
        $this->belongsTo("teacherId", "User", "id");
        $this->belongsTo("cohortId", "Cohort", "id");

        $this->hasManyToMany(
            "id",
            "ClassListUser",
            "classId",
            "studentId",
            "User",
            "id",
            array("alias" => "Users")
        );

        $this->hasManyToMany(
            "id",
            "NoticeBoardClasses",
            "classId",
            "noticeId",
            "NoticeBoard",
            "id",
            array("alias" => "Notices")
        );

        $this->hasMany("id", "Homework", "classId", array("alias" => "Homeworks"));
        $this->hasMany("id", "TimetableSlot", "classId", array("alias" => "Slots"));
    }

    public function getSource() {
        return "classlist";
    }

    public function getSlotIdsByDay($day) {
        $ids = array();

        foreach ($this->getSlots("day=$day") as $slot) {
            $ids []= $slot->timeSlotId;
        }

        return $ids;
    }

    public function getRooms() {
        $rooms = array();
        foreach ($this->slots as $slot) {
            if(!in_array($slot->room, $rooms)) {
                array_push($rooms, $slot->room);
            }
        }
        $response = "";
        foreach ($rooms as $room) {
            $response .= "$room ";
        }

        return $response;
    }

    public function getStartedHomework() {
        return $this->getHomeworks("status =" . Homework::$STARTED);
    }

    public function getPendingHomework() {
        return $this->getHomeworks("status = " . Homework::$PENDING);
    }

    public function getSubmittedHomework() {
        return $this->getHomeworks("status = " . Homework::$SUBMITTED);
    }

    public function columnMap() {
        return array(
            'schoolID' => 'schoolId',
            'classID' => 'id',
            'subjectID' => 'subjectId',
            'extraRef' => 'extraRef',
            'teacherID' => 'teacherId',
            'cohortId' => 'cohortId'
        );
    }
}
