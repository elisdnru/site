<?php

class m130328_130442_create_slideshow extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{slideshow}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'sort' => 'int(11) NOT NULL',
            'image' => 'varchar(255) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'text' => 'text NOT NULL',
            'url' => 'varchar(255) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('sort', '{{slideshow}}', 'sort');
    }

    public function safeDown()
    {
        $this->dropTable('{{slideshow}}');
    }
}