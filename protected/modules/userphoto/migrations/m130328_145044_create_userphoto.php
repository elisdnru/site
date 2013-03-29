<?php

class m130328_145044_create_userphoto extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{user_photo}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'user_id' => 'int(11) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'file' => 'varchar(255) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('user_id', '{{user_photo}}', 'user_id');
    }

    public function safeDown()
    {
        $this->dropTable('{{user_photo}}');
    }
}