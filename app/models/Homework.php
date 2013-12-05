<?php

class Homework extends \Phalcon\Mvc\Model {
    public $homeworkID;
    public $schoolID;
    public $teacherID;
    public $classID;
    public $timeslotID;
    public $setDate;
    public $dueDate;
    public $text;
    public $title;
    public $owner;

    public static $PENDING = 0;
    public static $STARTED = 1;
    public static $SUBMITTED = 2;
    public static $REVIEWED = 3;

    public function initialize() {
        $this->belongsTo("classId", "ClassList", "id");
        $this->hasMany("id", "HomeworkUser", "homeworkId",
            array("alias" => "works"));
    }

    public function getDueDate($format="D jS M Y") {
        return date($format, strtotime($this->dueDate));
    }

    public function getSetDate($format="D jS M Y") {
        return date($format, strtotime($this->setDate));
    }

    public static function findHomeworksByStatus($userId, $status) {
        if($status < 2) {
            $query = "studentId =?1 and status = ?2 order by dueDate";
        } else {
            $query = "studentId =?1 and status >= ?2 order by dueDate desc";
        }

        $params = array($query, "bind" => array(1 => $userId, 2 => $status));

        return Homework::find($params);
    }

    public static function findByTeacherAndStatus($userId, $status) {
        $homeworks = array();

        foreach (Homework::find("teacherId = " . $userId) as $key => $homework) {
            if(!$status) {
                foreach($homework->getWorks() as $work) {
                    $homeworks []= $work;
                }
            } else  {
                foreach($homework->getWorks("status =" . $status) as $work) {
                    $homeworks []= $work;
                }
            }
        }

        return $homeworks;


        return Homework::findFirst("owner = " . $userId)->works;
    }

    public static function findByClassAndStatus($classId, $status) {
        $homeworks = array();
        $classList = ClassList::findFirstById($classId);

        foreach ($classList->homeworks as $key => $homework) {
            foreach($homework->getWorks("status =" . $status) as $work) {
                $homeworks []= $work;
            }
        }
        return $homeworks;
    }

    public function columnMap() {
        return array(
            'homeworkID' => 'id',
            'schoolID' => 'schoolId',
            'teacherID' => 'teacherId',
            'classID' => 'classId',
            'timeslotID' => 'timeSlotId',
            'setDate' => 'setDate',
            'dueDate' => 'dueDate',
            'text' => 'text',
            'title' => 'title',
            'owner' => 'owner'
        );
    }
}
