<?php


class ResourcesProperties extends \Phalcon\Mvc\Model {
    public $id;
    public $resourceId;
    public $propertyId;

    public function columnMap() {
        return array(
            'id' => 'id',
            'resourceId' => 'resourceId',
            'propertyId' => 'propertyId'
        );
    }

}
