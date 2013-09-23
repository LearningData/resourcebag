<?php

class Homework extends \Phalcon\Mvc\Model {
    public $homeworkID;
    public $schoolID;
    public $studentID;
    public $teacherID;
    public $classID;
    public $timeslotID;
    public $setDate;
    public $dueDate;
    public $submittedDate;
    public $reviewedDate;
    public $text;
    public $status;

    public static $PENDING = 0;
    public static $STARTED = 1;
    public static $SUBMITTED = 2;
    public static $REVIEWED = 3;

    public function initialize() {
        $this->belongsTo("studentId", "User", "id", array("alias" =>"Student"));
        $this->hasMany("id", "HomeworkFile", "homeworkId", array("alias" => "Files"));
    }

    public function getStatus() {
        if ($this->reviewedDate == "0000-00-00" and
            $this->submittedDate != "0000-00-00") {

            return "submitted";
        }

        if ($this->reviewedDate != "0000-00-00") {
            return "reviewed";
        }

        return "pending";
    }

    public function isPending() {
        return $this->status == Homework::$PENDING;
    }

    public function isSubmitted() {
        return $this->status == Homework::$SUBMITTED;
    }

    public static function findHomeworksByStatus($userId, $classId, $status) {
        $query = "classId = $classId and studentId = $userId and status = $status";

        return Homework::find($query);
    }

    public function columnMap() {
        return array(
            'homeworkID' => 'id',
            'schoolID' => 'schoolId',
            'studentID' => 'studentId',
            'teacherID' => 'teacherId',
            'classID' => 'classId',
            'timeslotID' => 'timeSlotId',
            'setDate' => 'setDate',
            'dueDate' => 'dueDate',
            'submittedDate' => 'submittedDate',
            'reviewedDate' => 'reviewedDate',
            'text' => 'text',
            'status' => 'status'
        );
    }
}
