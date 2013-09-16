<?php

class Config extends \Phalcon\Mvc\Model {
    public $name;
    public $value;
    public $id;

    public function columnMap() {
        return array(
            'name' => 'name',
            'value' => 'value',
            'id' => 'id'
        );
    }
}
