<?php

class UserPhoto extends \Phalcon\Mvc\Model {
    public $name;
    public $size;
    public $type;
    public $file;
    public $userId;
    public $id;

    public function columnMap() {
        return array(
            'name' => 'name',
            'size' => 'size',
            'type' => 'type',
            'file' => 'file',
            'userId' => 'userId',
            'id' => 'id'
        );
    }
}
