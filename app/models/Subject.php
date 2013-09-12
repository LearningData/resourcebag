<?php

class Subject extends \Phalcon\Mvc\Model {
    public $ID;
    public $subject;

    public getSource() {
        return "subjects";
    }

    public function columnMap() {
        return array(
            'ID' => 'id',
            'subject' => 'name'
        );
    }
}
