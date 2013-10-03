<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

class TopicsMigration_103 extends Migration
{

    public function up()
    {
        $this->morphTable(
            'topics',
            array(
            'columns' => array(
                new Column(
                    'schoolID',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'size' => 11,
                        'first' => true
                    )
                ),
                new Column(
                    'topicID',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'autoIncrement' => true,
                        'size' => 11,
                        'after' => 'schoolID'
                    )
                ),
                new Column(
                    'date',
                    array(
                        'type' => Column::TYPE_DATETIME,
                        'notNull' => true,
                        'size' => 1,
                        'after' => 'topicID'
                    )
                ),
                new Column(
                    'title',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 30,
                        'after' => 'date'
                    )
                ),
                new Column(
                    'text',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'notNull' => true,
                        'size' => 255,
                        'after' => 'title'
                    )
                ),
                new Column(
                    'topicOwner',
                    array(
                        'type' => Column::TYPE_INTEGER,
                        'notNull' => true,
                        'size' => 11,
                        'after' => 'text'
                    )
                ),
                new Column(
                    'fileAttached',
                    array(
                        'type' => Column::TYPE_VARCHAR,
                        'size' => 100,
                        'after' => 'topicOwner'
                    )
                )
            ),
            'indexes' => array(
                new Index('PRIMARY', array('topicID'))
            ),
            'options' => array(
                'TABLE_TYPE' => 'BASE TABLE',
                'AUTO_INCREMENT' => '32',
                'ENGINE' => 'MyISAM',
                'TABLE_COLLATION' => 'latin1_swedish_ci'
            )
        )
        );
    }
}
