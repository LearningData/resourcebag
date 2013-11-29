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
    public $expiryDate;

    public function initialize() {
        $this->hasMany("id", "NoticeBoardFile", "noticeId", array("alias" => "Files"));
        $this->belongsTo("uploadedBy", "User", "id", array("alias" =>"Author"));

        $this->hasManyToMany(
            "id",
            "NoticeBoardClasses",
            "noticeId",
            "classId",
            "ClassList",
            "id",
            array("alias" => "Classes")
        );
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

    public function getDate($format="D jS M Y") {
        return date($format, strtotime($this->date));
    }

    public static function getStudentNotices($user) {
        $today = date("Y-m-d");
        $query = "(userType = 'P' or userType = 'A') and " .
            "'$today' >= date and '$today' <= expiryDate order by date desc";

        return NoticeBoard::noticesByClassesAndQuery($user->classes, $query,
            $user);
    }

    public static function getTeacherNotices($user) {
        $classes = ClassList::findByTeacherId($user->id);
        $today = date("Y-m-d");
        $query = "'$today' >= date and '$today' <= expiryDate order by date desc";

        return NoticeBoard::noticesByClassesAndQuery($classes, $query, $user);
    }

    public function columnMap() {
        return array(
            'schoolID' => 'schoolId',
            'date' => 'date',
            'expiryDate' => 'expiryDate',
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



    private function noticesByClassesAndQuery($classes, $query, $user=null) {
        $notices = array();

        foreach ($classes as $classList) {
            foreach ($classList->getNotices($query) as $notice) {
                if(!in_array($notice, $notices)) {
                    array_push($notices, $notice);
                }
            }
        }

        $today = date("Y-m-d");

        $queryForAll = "schoolId = " . $user->schoolId . " and userType = 'A' " .
            "and '$today' >= date and '$today' <= expiryDate " .
            "order by date desc";

        $result = NoticeBoard::find($queryForAll);

        foreach ($result as $notice) {
            if(!in_array($notice, $notices)) {
                array_push($notices, $notice);
            }
        }

        function comparator($d1, $d2) {
            return strtotime($d1->date) < strtotime($d2->date);
        }

        usort($notices, 'comparator');
        return $notices;
    }
}
