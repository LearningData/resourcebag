<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

class EventsMigration_108 extends Migration
{

    public function up()
    {
        $this->morphTable(
            'events',
            array(
            'columns' => array(
                new Column(
                    'title',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 100,
                        'first' => true
                    )
                ),
                new Column(
                    'startDate',
                    array(
                        'type' => Column::TYPE_DATETIME,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'title'
                    )
                ),
                new Column(
                    'endDate',
                    array(
                        'type' => Column::TYPE_DATETIME,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'startDate'
                    )
                ),
                new Column(
                    'location',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'size' => 200,
                        'after' => 'endDate'
                    )
                ),
                new Column(
                    'contact',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'size' => 100,
                        'after' => 'location'
                    )
                ),
                new Column(
                    'description',
                    array(
                        'type' => Column::TYPE_TEXT,
                        'size' => 1,
                        'after' => 'contact'
                    )
                ),
                new Column(
                    'allDay',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'size' => 11,
                        'after' => 'description'
                    )
                ),
                new Column(
                    'createdAt',
                    array(
                        'type' => Column::TYPE_DATETIME,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'allDay'
                    )
                ),
                new Column(
                    'id',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'autoIncrement' => true,
                        'size' => 9,
                        'after' => 'createdAt'
                    )
                ),
                new Column(
                    'userId',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'size' => 9,
                        'after' => 'id'
                    )
                ),
                new Column(
                    'link',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'size' => 200,
                        'after' => 'userId'
                    )
                )
            ),
            'indexes' => array(
                new Index('PRIMARY', array('id'))
            ),
            'options' => array(
                'TABLE_TYPE' => 'BASE TABLE',
                'AUTO_INCREMENT' => '3',
                'ENGINE' => 'InnoDB',
                'TABLE_COLLATION' => 'latin1_swedish_ci'
            )
        )
        );
    }
}
