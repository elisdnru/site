<?php

class m130329_081136_create_session extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{session}}', array(
            'id' => 'char(32) NOT NULL PRIMARY KEY',
            'expire' => 'int(11) DEFAULT NULL',
            'data' => 'text',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('expire', '{{session}}', 'expire');
    }

    public function safeDown()
    {
        $this->dropTable('{{session}}');
    }
}