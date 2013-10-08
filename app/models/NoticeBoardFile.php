<?php

class NoticeBoardFile extends \Phalcon\Mvc\Model {
    public $name;
    public $originalName;
    public $size;
    public $type;
    public $file;
    public $noticeboardId;
    public $id;

    public function getSource() {
        return "noticeboard_files";
    }

    public function columnMap() {
        return array(
            'name' => 'name',
            'originalName' => 'originalName',
            'size' => 'size',
            'type' => 'type',
            'file' => 'file',
            'noticeboardId' => 'noticeId',
            'id' => 'id'
        );
    }

}
