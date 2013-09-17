<?php

class TimetableConfig extends \Phalcon\Mvc\Model {
    public $schoolID;
    public $timeslotID;
    public $startTime;
    public $endTime;
    public $Preset;
    public $year;
    public $weekDay;


    public function getSource() {
        return "timetableconfig";
    }

    public function columnMap() {
        return array(
            "id" => "id",
            'schoolID' => 'schoolId',
            'timeslotID' => 'timeSlotId',
            'startTime' => 'startTime',
            'endTime' => 'endTime',
            'Preset' => 'preset',
            'year' => 'year',
            'weekDay' => 'weekDay'
        );
    }

}
