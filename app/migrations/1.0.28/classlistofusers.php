<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

class ClasslistofusersMigration_1028 extends Migration
{

    public function up()
    {
        $this->morphTable(
            'classlistofusers',
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
                    'classID',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'size' => 5,
                        'after' => 'schoolID'
                    )
                ),
                new Column(
                    'studentID',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'size' => 11,
                        'after' => 'classID'
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
