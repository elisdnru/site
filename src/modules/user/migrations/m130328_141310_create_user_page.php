<?php

class m130328_141310_create_user_page extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{user_page}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'user_id' => 'int(11) NOT NULL',
            'page_id' => 'int(11) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('user_id', '{{user_page}}', 'user_id');
        $this->createIndex('page_id', '{{user_page}}', 'page_id');
    }

    public function safeDown()
    {
        $this->dropTable('{{user_page}}');
    }
}