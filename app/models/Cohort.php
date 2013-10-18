<?php

class Cohort extends \Phalcon\Mvc\Model {
    public $schoolYear;
    public $schoolId;
    public $stage;
    public $courseId;
    public $id;

    public function getSource() {
        return "cohorts";
    }

    public function columnMap() {
        return array(
            'schoolYear' => 'schoolYear',
            'schoolId' => 'schoolId',
            'stage' => 'stage',
            'courseId' => 'courseId',
            'id' => 'id'
        );
    }
}
