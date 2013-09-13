<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

class TimetableconfigMigration_100 extends Migration
{

    public function up()
    {
        $this->morphTable(
            'timetableconfig',
            array(
            'columns' => array(
                new Column(
                    'schoolID',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'size' => 5,
                        'first' => true
                    )
                ),
                new Column(
                    'timeslotID',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'size' => 4,
                        'after' => 'schoolID'
                    )
                ),
                new Column(
                    'startTime',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'timeslotID'
                    )
                ),
                new Column(
                    'endTime',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'startTime'
                    )
                ),
                new Column(
                    'Preset',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'size' => 20,
                        'after' => 'endTime'
                    )
                ),
                new Column(
                    'year',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 1,
                        'after' => 'Preset'
                    )
                ),
                new Column(
                    'weekDay',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 1,
                        'after' => 'year'
                    )
                )
            ),
            'options' => array(
                'TABLE_TYPE' => 'BASE TABLE',
                'AUTO_INCREMENT' => '',
                'ENGINE' => 'MyISAM',
                'TABLE_COLLATION' => 'latin1_swedish_ci'
            )
        )
        );
    }
}
