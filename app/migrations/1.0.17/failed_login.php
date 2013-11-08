<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

class FailedLoginMigration_1017 extends Migration
{

    public function up()
    {
        $this->morphTable(
            'failed_login',
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
                    'userId',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'size' => 11,
                        'after' => 'id'
                    )
                ),
                new Column(
                    'ipAddress',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'size' => 15,
                        'after' => 'userId'
                    )
                ),
                new Column(
                    'userAgent',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'size' => 300,
                        'after' => 'ipAddress'
                    )
                ),
                new Column(
                    'date',
                    array(
                        'type' => Column::TYPE_DATETIME,
                        'size' => 1,
                        'after' => 'userAgent'
                    )
                )
            ),
            'indexes' => array(
                new Index('PRIMARY', array('id'))
            ),
            'options' => array(
                'TABLE_TYPE' => 'BASE TABLE',
                'AUTO_INCREMENT' => '6',
                'ENGINE' => 'InnoDB',
                'TABLE_COLLATION' => 'latin1_swedish_ci'
            )
        )
        );
    }
}
