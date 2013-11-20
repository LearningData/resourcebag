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
    public $textEditor;
    public $status;
    public $title;

    public static $PENDING = 0;
    public static $STARTED = 1;
    public static $SUBMITTED = 2;
    public static $REVIEWED = 3;

    public function initialize() {
        $this->belongsTo("studentId", "User", "id", array("alias" =>"Student"));
        $this->belongsTo("classId", "ClassList", "id");
        $this->hasMany("id", "HomeworkFile", "homeworkId", array("alias" => "Files"));
    }

    public function getDueDate($format="D jS M Y") {
        return date($format, strtotime($this->dueDate));
    }

    public function getSetDate($format="D jS M Y") {
        return date($format, strtotime($this->setDate));
    }

    public function getSubmittedDate($format="D jS M Y") {
        return date($format, strtotime($this->submittedDate));
    }

    public function getReviewedDate($format="D jS M Y") {
        return date($format, strtotime($this->reviewedDate));
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

    public function isReviewed() {
        return $this->status == Homework::$REVIEWED;
    }

    public static function findHomeworksByStatus($userId, $status) {
        $query = "studentId =?1 and status = ?2 order by dueDate desc";
        $params = array($query, "bind" => array(1 => $userId, 2 => $status));

        return Homework::find($params);
    }

    public static function findByTeacherAndStatus($userId, $status) {
        if ($status != "") {
            $query = "teacherId =?1 and status = ?2 order by dueDate desc";
        } else {
            $query = "teacherId =?1 and status >= ?2 order by status, dueDate desc";
        }

        $params = array($query, "bind" => array(1 => $userId, 2 => $status));

        return Homework::find($params);
    }

    public static function findByClassAndStatus($classId, $status) {
        if ($status != "") {
            $query = "classId =?1 and status = ?2";
        } else {
            $query = "classId =?1 and status >= ?2";
        }

        $params = array($query, "bind" => array(1 => $classId, 2 => $status));

        return Homework::find($params);
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
            'textEditor' => 'textEditor',
            'status' => 'status',
            'title' => 'title'
        );
    }
}
