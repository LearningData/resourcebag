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

    public static function findBySchoolAndDay($schoolId, $day) {
        $conditions = "schoolId = ?1 AND weekDay = ?2 order by startTime";
        $parameters = array(1 => $schoolId, 2 => $day);
        $params = array($conditions, "bind" => $parameters);

        $configs = TimetableConfig::find($params);

        return $configs;
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
