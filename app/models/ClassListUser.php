<?php

class ClassListUser extends \Phalcon\Mvc\Model {
    public $schoolID;
    public $classID;
    public $studentID;

    public function getSource() {
        return "classlistofusers";
    }

    public function columnMap() {
        return array(
            'schoolID' => 'schoolId',
            'classID' => 'classId',
            'studentID' => 'studentId'
        );
    }

}
