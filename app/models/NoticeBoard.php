<?php

class NoticeBoard extends \Phalcon\Mvc\Model {
    public $schoolID;
    public $date;
    public $text;
    public $title;
    public $category;
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

    public static function getCategories() {
        return array("Meeting" => "Meeting",
            "Sport" => "Sport",
            "After School" => "After School",
            "Announcements" => "Announcements",
            "Celebration / Congratulations" => "Celebration / Congratulations",
            "Thanks" => "Thanks",
            "Notice" => "Notice"
        );
    }

    public function getDate() {
        return date("d-m-Y", strtotime($this->date));
    }

    public static function getStudentNotices($user) {
        $classIdParams = ClassListService::classesToIds($user->classes);

        $query = "schoolId = ?1 and classId in ( ?2 ) and " .
                 "(userType = 'P' or userType = 'A') order by date desc";

        $values = array(1 => $user->schoolId, 2 => $classIdParams);
        $params = array($query, "bind" => $values);

        return NoticeBoard::find($params);
    }

    public static function getTeacherNotices($user) {
        $classes = ClassList::findByTeacherId($user->id);
        $classIdParams = ClassListService::classesToIds($classes);

        $query = "schoolId = ?1 and (classId in ( ?2 ) or classId is null) and " .
                 "(userType = 'T' or userType = 'A') order by date desc";

        $values = array(1 => $user->schoolId, 2 => $classIdParams);
        $params = array($query, "bind" => $values);


        return NoticeBoard::find($params);
    }

    public function columnMap() {
        return array(
            'schoolID' => 'schoolId',
            'date' => 'date',
            'text' => 'text',
            'title' => 'title',
            'category' => 'category',
            'userType' => 'userType',
            'uploadedBy' => 'uploadedBy',
            'classID' => 'classId',
            'fileAttached' => 'fileAttached',
            'id' => 'id'
        );
    }
}
