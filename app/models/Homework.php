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


    public function columnMap() {
        return array(
            'homeworkID' => 'homeworkId',
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
