<?php

class Config extends \Phalcon\Mvc\Model {
    public $name;
    public $value;
    public $id;


    public function schoolYear() {
        $params = array("name = ?1", "bind" => array(1 => "schoolYear"));
        $year = Config::findFirst($params);

        if($year) { return $year->value; }

        return date("Y");
    }

    public function columnMap() {
        return array(
            'name' => 'name',
            'value' => 'value',
            'id' => 'id'
        );
    }
}
