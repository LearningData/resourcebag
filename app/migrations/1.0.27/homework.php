<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

class HomeworkMigration_1027 extends Migration
{

    public function up()
    {
        $this->morphTable(
            'homework',
            array(
            'columns' => array(
                new Column(
                    'homeworkID',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'autoIncrement' => true,
                        'size' => 11,
                        'first' => true
                    )
                ),
                new Column(
                    'schoolID',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'size' => 5,
                        'after' => 'homeworkID'
                    )
                ),
                new Column(
                    'teacherID',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'size' => 8,
                        'after' => 'schoolID'
                    )
                ),
                new Column(
                    'classID',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'size' => 8,
                        'after' => 'teacherID'
                    )
                ),
                new Column(
                    'timeslotID',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'size' => 4,
                        'after' => 'classID'
                    )
                ),
                new Column(
                    'setDate',
                    array(
                        'type' => Column::TYPE_DATE,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'timeslotID'
                    )
                ),
                new Column(
                    'dueDate',
                    array(
                        'type' => Column::TYPE_DATE,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'setDate'
                    )
                ),
                new Column(
                    'text',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 1000,
                        'after' => 'dueDate'
                    )
                ),
                new Column(
                    'title',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'size' => 100,
                        'after' => 'text'
                    )
                ),
                new Column(
                    'owner',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'size' => 8,
                        'after' => 'title'
                    )
                )
            ),
            'indexes' => array(
                new Index('PRIMARY', array('homeworkID'))
            ),
            'options' => array(
                'TABLE_TYPE' => 'BASE TABLE',
                'AUTO_INCREMENT' => '134',
                'ENGINE' => 'MyISAM',
                'TABLE_COLLATION' => 'latin1_swedish_ci'
            )
        )
        );
    }
}
