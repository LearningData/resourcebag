<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

class TimetableslotsMigration_1028 extends Migration
{

    public function up()
    {
        $this->morphTable(
            'timetableslots',
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
                    'Day',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'schoolID'
                    )
                ),
                new Column(
                    'timeslotID',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'size' => 4,
                        'after' => 'Day'
                    )
                ),
                new Column(
                    'classID',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'size' => 5,
                        'after' => 'timeslotID'
                    )
                ),
                new Column(
                    'Room',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 10,
                        'after' => 'classID'
                    )
                ),
                new Column(
                    'id',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'autoIncrement' => true,
                        'size' => 11,
                        'after' => 'Room'
                    )
                )
            ),
            'indexes' => array(
                new Index('PRIMARY', array('id'))
            ),
            'options' => array(
                'TABLE_TYPE' => 'BASE TABLE',
                'AUTO_INCREMENT' => '69',
                'ENGINE' => 'InnoDB',
                'TABLE_COLLATION' => 'latin1_swedish_ci'
            )
        )
        );
    }
}
