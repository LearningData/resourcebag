<?php

class ClassList extends \Phalcon\Mvc\Model {

    public $schoolID;
    public $classID;
    public $year;
    public $subjectID;
    public $extraRef;
    public $teacherID;
    public $schyear;

    public function initialize() {
        $this->belongsTo("subjectId", "Subject", "id");
        $this->belongsTo("schoolId", "School", "id");
        $this->belongsTo("teacherId", "User", "id");

        $this->hasManyToMany(
            "id",
            "ClassListUser",
            "classId",
            "studentId",
            "User",
            "id",
            array("alias" => "Users")
        );

        $this->hasMany("id", "Homework", "classId", array("alias" => "Homeworks"));
    }

    public static function getClassesByTeacherId($teacherId) {
        return ClassList::find("teacherId = $teacherId");
    }

    public function getSource() {
        return "classlist";
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
            'year' => 'year',
            'subjectID' => 'subjectId',
            'extraRef' => 'extraRef',
            'teacherID' => 'teacherId',
            'schyear' => 'schyear'
        );
    }
}
