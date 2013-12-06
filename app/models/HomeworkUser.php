<?php


class HomeworkUser extends \Phalcon\Mvc\Model {
    public $id;
    public $homeworkId;
    public $studentId;
    public $submittedDate;
    public $reviewedDate;
    public $text;
    public $status;

    public function initialize() {
        $this->hasMany("id", "HomeworkFile", "homeworkId",
            array("alias" => "Files"));
        $this->belongsTo("studentId", "User", "id", array("alias" =>"Student"));
        $this->belongsTo("homeworkId", "Homework", "id", array("alias" =>"Info"));
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

    public function columnMap() {
        return array(
            'id' => 'id',
            'homeworkId' => 'homeworkId',
            'studentId' => 'studentId',
            'submittedDate' => 'submittedDate',
            'reviewedDate' => 'reviewedDate',
            'text' => 'text',
            'status' => 'status'
        );
    }
}
