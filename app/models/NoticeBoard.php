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

    public function getDate() {
        return date("d-m-Y", strtotime($this->date));
    }

    public static function getStudentNotices($user) {
        $classIdParams = ClassListService::classesToIds($user->classes);

        $notices = NoticeBoard::find("schoolId = " . $user->schoolId .
            " and classId in (" . $classIdParams . ")" .
            " and (userType = 'P' or userType = 'A') order by date desc");

        return $notices;
    }

    public static function getTeacherNotices($user) {
        $classes = ClassList::getClassesByTeacherId($user->id);
        $classIdParams = ClassListService::classesToIds($classes);

        $notices = NoticeBoard::find("schoolId = " . $user->schoolId .
            " and classId in (" . $classIdParams . ")" .
            " and (userType = 'T' or userType = 'A') order by date desc");

        return $notices;
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
