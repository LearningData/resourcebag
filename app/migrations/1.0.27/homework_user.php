<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

class HomeworkUserMigration_1027 extends Migration
{

    public function up()
    {
        $this->morphTable(
            'homework_user',
            array(
            'columns' => array(
                new Column(
                    'id',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'autoIncrement' => true,
                        'size' => 11,
                        'first' => true
                    )
                ),
                new Column(
                    'homeworkId',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'size' => 11,
                        'after' => 'id'
                    )
                ),
                new Column(
                    'studentId',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'size' => 11,
                        'after' => 'homeworkId'
                    )
                ),
                new Column(
                    'submittedDate',
                    array(
                        'type' => Column::TYPE_DATETIME,
                        'size' => 1,
                        'after' => 'studentId'
                    )
                ),
                new Column(
                    'reviewedDate',
                    array(
                        'type' => Column::TYPE_DATETIME,
                        'size' => 1,
                        'after' => 'submittedDate'
                    )
                ),
                new Column(
                    'text',
                    array(
                        'type' => Column::TYPE_TEXT,
                        'size' => 1,
                        'after' => 'reviewedDate'
                    )
                ),
                new Column(
                    'status',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'text'
                    )
                )
            ),
            'indexes' => array(
                new Index('PRIMARY', array('id'))
            ),
            'options' => array(
                'TABLE_TYPE' => 'BASE TABLE',
                'AUTO_INCREMENT' => '231',
                'ENGINE' => 'InnoDB',
                'TABLE_COLLATION' => 'latin1_swedish_ci'
            )
        )
        );
    }
}
