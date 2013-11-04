<?php

class Subject extends \Phalcon\Mvc\Model {
    public $ID;
    public $subject;

    public function initialize() {
        $this->hasMany("id", "ClassList", "subjectId",
            array("alias" => "Classes"));
    }

    public function getSource() {
        return "subjects";
    }

    public function columnMap() {
        return array(
            'ID' => 'id',
            'subject' => 'name'
        );
    }
}
