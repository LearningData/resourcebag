<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

class ResourcePropertyMigration_1025 extends Migration
{

    public function up()
    {
        $this->morphTable(
            'resource_property',
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
                    'name',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'size' => 100,
                        'after' => 'id'
                    )
                ),
                new Column(
                    'type',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'size' => 100,
                        'after' => 'name'
                    )
                )
            ),
            'indexes' => array(
                new Index('PRIMARY', array('id'))
            ),
            'options' => array(
                'TABLE_TYPE' => 'BASE TABLE',
                'AUTO_INCREMENT' => '11',
                'ENGINE' => 'InnoDB',
                'TABLE_COLLATION' => 'latin1_swedish_ci'
            )
        )
        );
    }
}
