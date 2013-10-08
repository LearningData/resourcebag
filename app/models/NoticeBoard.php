<?php

class NoticeBoard extends \Phalcon\Mvc\Model {
    public $schoolID;
    public $date;
    public $text;
    public $userType;
    public $uploadedBy;
    public $classID;
    public $fileAttached;

    public function initialize() {
        $this->hasMany("id", "NoticeBoardFile", "noticeId", array("alias" => "Files"));
        $this->belongsTo("uploadedBy", "User", "id", array("alias" =>"Author"));
    }

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
            'fileAttached' => 'fileAttached',
            'id' => 'id'
        );
    }
}
