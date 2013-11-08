<?php

class ResourceProperty extends \Phalcon\Mvc\Model {
    public $id;
    public $name;
    public $type;

    public function columnMap() {
        return array(
            'id' => 'id',
            'name' => 'name',
            'type' => 'type'
        );
    }

}
