<?php

class Group extends \Phalcon\Mvc\Model {
    public $id;
    public $name;
    public $year;
    public $type;

    public function initialize() {
        $this->hasMany("id", "Cohort", "groupId", array("alias" => "Cohorts"));

        $this->hasManyToMany(
            "id",
            "GroupMembers",
            "groupId",
            "userId",
            "User",
            "id",
            array("alias" => "Students")
        );
    }

    public function getSource() {
        return "groups";
    }

    public function columnMap() {
        return array(
            'id' => 'id',
            'name' => 'name',
            'year' => 'year',
            'type' => 'type'
        );
    }
}
