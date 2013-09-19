<?php


class NoticeBoard extends \Phalcon\Mvc\Model {
    public $schoolID;
    public $date;
    public $text;
    public $userType;
    public $uploadedBy;
    public $classID;
    public $fileAttached;

    public function getSource() {
        return "noticeboard";
    }

    public function columnMap() {
        return array(
            'schoolID' => 'schoolId',
            'date' => 'date',
            'text' => 'text',
            'userType' => 'userType',
            'uploadedBy' => 'uploadedBy',
            'classID' => 'classId',
            'fileAttached' => 'fileAttached'
        );
    }

}
