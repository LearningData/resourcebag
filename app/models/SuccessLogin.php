<?php


class SuccessLogin extends \Phalcon\Mvc\Model {
    public $id;
    public $userId;
    public $ipAddress;
    public $userAgent;
    public $loggedAt;

    public function columnMap() {
        return array(
            'id' => 'id',
            'userId' => 'userId',
            'ipAddress' => 'ipAddress',
            'userAgent' => 'userAgent',
            'loggedAt' => 'loggedAt'
        );
    }

}
