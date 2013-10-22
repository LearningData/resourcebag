<?php


class GroupMembers extends \Phalcon\Mvc\Model {
    public $id;
    public $userId;
    public $groupId;

    public function columnMap() {
        return array(
            'id' => 'id',
            'userId' => 'userId',
            'groupId' => 'groupId'
        );
    }

}
