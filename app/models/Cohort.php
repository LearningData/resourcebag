<?php

class Cohort extends \Phalcon\Mvc\Model {
    public $schoolYear;
    public $schoolId;
    public $stage;
    public $courseId;
    public $id;
    public $groupId;

    public function initialize() {
        $this->hasMany("id", "ClassList", "cohortId", array("alias" => "Classes"));
        $this->belongsTo("groupId", "Group", "id");
    }

    public function getSource() {
        return "cohorts";
    }

    public function columnMap() {
        return array(
            'schoolYear' => 'schoolYear',
            'schoolId' => 'schoolId',
            'stage' => 'stage',
            'courseId' => 'courseId',
            'groupId' => 'groupId',
            'id' => 'id'
        );
    }
}
