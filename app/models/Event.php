<?php


class Event extends \Phalcon\Mvc\Model {
    public $title;
    public $startDate;
    public $endDate;
    public $location;
    public $contact;
    public $description;
    public $allDay;
    public $createdAt;
    public $id;
    public $userId;
    public $link;

    public function initialize() {
        $this->belongsTo("userId", "User", "id");
    }

    public function beforeSave() {
        $http = substr($this->link, 0, strlen("http://"));
        $https = substr($this->link, 0, strlen("https://"));
        if(strcmp($http, "http://") === 1 && strcmp($https, "https://") === 1){
            $this->link = "http://" . $this->link;
        }
    }

    public function getSource() {
        return "events";
    }

    public function columnMap() {
        return array(
            'title' => 'title',
            'startDate' => 'start',
            'endDate' => 'end',
            'location' => 'location',
            'contact' => 'contact',
            'description' => 'description',
            'allDay' => 'allDay',
            'createdAt' => 'createdAt',
            'id' => 'id',
            'userId' => 'userId',
            'link' => 'url'
        );
    }

}
