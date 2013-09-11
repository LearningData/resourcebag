<?php

class School extends \Phalcon\Mvc\Model {
    public $schoolID;
    public $SchoolName;
    public $Address;
    public $SchoolPath;
    public $AccessCode;
    public $TeacherAccessCode;
    public $allTY;

    public function getSource() {
        return "schoolinfo";
    }

    public function users() {
        return User::query()
                            ->where("schoolId = :id:")
                            ->bind(array("id" => $this->id))
                            ->execute();
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
