<?php

class ClassList extends \Phalcon\Mvc\Model {

    public $schoolID;
    public $classID;
    public $year;
    public $subjectID;
    public $extraRef;
    public $teacherID;
    public $schyear;

    public function getSource() {
        return "classlist";
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