<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

class SubjectsMigration_1011 extends Migration
{

    public function up()
    {
        $this->morphTable(
            'subjects',
            array(
            'columns' => array(
                new Column(
                    'ID',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'size' => 2,
                        'first' => true
                    )
                ),
                new Column(
                    'subject',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'size' => 72,
                        'after' => 'ID'
                    )
                )
            ),
            'options' => array(
                'TABLE_TYPE' => 'BASE TABLE',
                'AUTO_INCREMENT' => '',
                'ENGINE' => 'MyISAM',
                'TABLE_COLLATION' => 'utf8_general_ci'
            )
        )
        );
    }
}
