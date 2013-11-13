<?php


class NoticeBoardClasses extends \Phalcon\Mvc\Model {
    public $id;
    public $schoolId;
    public $classId;
    public $noticeId;

    public function getSource() {
        return "noticeboardclasses";
    }

    public function columnMap() {
        return array(
            'id' => 'id',
            'schoolId' => 'schoolId',
            'classId' => 'classId',
            'noticeId' => 'noticeId'
        );
    }

}
