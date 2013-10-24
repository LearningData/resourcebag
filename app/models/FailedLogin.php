<?php


class FailedLogin extends \Phalcon\Mvc\Model {
    public $id;
    public $userId;
    public $ipAddress;
    public $userAgent;
    public $date;

    public function columnMap() {
        return array(
            'id' => 'id',
            'userId' => 'userId',
            'ipAddress' => 'ipAddress',
            'userAgent' => 'userAgent',
            'date' => 'date'
        );
    }

}
