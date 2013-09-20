<?php

class HomeworkFile extends \Phalcon\Mvc\Model {
    public $name;
    public $originalName;
    public $size;
    public $type;
    public $file;
    public $homeworkId;
    public $id;

    public function getSource() {
        return "homework_files";
    }

    public function columnMap() {
        return array(
            'name' => 'name',
            'originalName' => 'originalName',
            'size' => 'size',
            'type' => 'type',
            'file' => 'file',
            'homeworkId' => 'homeworkId',
            'id' => 'id'
        );
    }
}
