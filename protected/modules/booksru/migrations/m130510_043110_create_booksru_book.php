<?php

class m130510_043110_create_booksru_book extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{booksru_book}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'code' => 'int(11) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'author' => 'varchar(255) NOT NULL',
            'alias' => 'varchar(255) NOT NULL',
            'image' => 'varchar(255) NOT NULL',
            'image_width' => 'int(11) NOT NULL',
            'image_height' => 'int(11) NOT NULL',
            'free' => 'tinyint(1) NOT NULL',
            'short' => 'text NOT NULL',
            'short_purified' => 'text NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
    }

    public function safeDown()
    {
        $this->dropTable('{{booksru_book}}');
    }
}