<?php

class HomeworkFile extends \Phalcon\Mvc\Model {
    public $name;
    public $description;
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
            'description' => 'description',
            'originalName' => 'originalName',
            'size' => 'size',
            'type' => 'type',
            'file' => 'file',
            'homeworkId' => 'homeworkId',
            'id' => 'id'
        );
    }
}
