<?php

class Resource extends \Phalcon\Mvc\Model {
    public $id;
    public $description;
    public $date;
    public $subjectId;
    public $teacherId;
    public $fileName;

    public function initialize() {
        $this->hasManyToMany(
            "id",
            "ResourcesProperties",
            "resourceId",
            "propertyId",
            "ResourceProperty",
            "id",
            array("alias" => "Properties")
        );
    }

    public function getSource() {
        return "resources";
    }

    public function columnMap() {
        return array(
            'id' => 'id',
            'description' => 'description',
            'date' => 'date',
            'subjectId' => 'subjectId',
            'teacherId' => 'teacherId',
            'fileName' => 'fileName',
        );
    }

}