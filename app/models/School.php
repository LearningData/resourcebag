<?php

class School extends \Phalcon\Mvc\Model {
    public $schoolID;
    public $SchoolName;
    public $Address;
    public $SchoolPath;
    public $AccessCode;
    public $TeacherAccessCode;
    public $allTY;

    public function initialize() {
        $this->hasMany("id", "User", "schoolId", array("alias" => "Users"));
        $this->hasMany("id", "ClassList", "schoolId", array("alias" => "Classes"));
    }

    public function getSource() {
        return "schoolinfo";
    }

    public function users() {
        return $this->getRelated("User");
    }

    public function columnMap() {
        return array(
            'schoolID' => 'id',
            'SchoolName' => 'name',
            'Address' => 'address',
            'SchoolPath' => 'path',
            'AccessCode' => 'accessCode',
            'TeacherAccessCode' => 'teacherAccessCode',
            'allTY' => 'allTY'
        );
    }
}
