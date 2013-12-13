<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

class SchoolinfoMigration_1028 extends Migration
{

    public function up()
    {
        $this->morphTable(
            'schoolinfo',
            array(
            'columns' => array(
                new Column(
                    'schoolID',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'autoIncrement' => true,
                        'size' => 5,
                        'first' => true
                    )
                ),
                new Column(
                    'SchoolName',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 35,
                        'after' => 'schoolID'
                    )
                ),
                new Column(
                    'Address',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 40,
                        'after' => 'SchoolName'
                    )
                ),
                new Column(
                    'SchoolPath',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 100,
                        'after' => 'Address'
                    )
                ),
                new Column(
                    'AccessCode',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 8,
                        'after' => 'SchoolPath'
                    )
                ),
                new Column(
                    'TeacherAccessCode',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'size' => 8,
                        'after' => 'AccessCode'
                    )
                ),
                new Column(
                    'allTY',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'TeacherAccessCode'
                    )
                ),
                new Column(
                    'clientId',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'size' => 100,
                        'after' => 'allTY'
                    )
                )
            ),
            'indexes' => array(
                new Index('PRIMARY', array('schoolID')),
                new Index('SchoolName', array('SchoolName', 'Address'))
            ),
            'options' => array(
                'TABLE_TYPE' => 'BASE TABLE',
                'AUTO_INCREMENT' => '76',
                'ENGINE' => 'MyISAM',
                'TABLE_COLLATION' => 'latin1_swedish_ci'
            )
        )
        );
    }
}
