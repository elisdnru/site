<?php

class m130904_103611_create_gallery_photo extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{gallery_photo}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'date' => 'datetime NOT NULL',
            'update_date' => 'datetime NOT NULL',
            'category_id' => 'int(11) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'pagetitle' => 'varchar(255) NOT NULL',
            'description' => 'text NOT NULL',
            'keywords' => 'varchar(255) NOT NULL',
            'text' => 'mediumtext NOT NULL',
            'text_purified' => 'mediumtext NOT NULL',
            'image' => 'varchar(255) NOT NULL',
            'image_width' => 'int(11) NOT NULL',
            'image_height' => 'int(11) NOT NULL',
            'image_alt' => 'varchar(255) NOT NULL',
            'video' => 'varchar(255) NOT NULL',
            'public' => 'tinyint(1) NOT NULL',
            'comments_count' => 'int(11) NOT NULL',
            'comments_new_count' => 'int(11) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('category_id', '{{gallery_photo}}', 'category_id');

        $this->createIndex('date', '{{gallery_photo}}', 'date');
        $this->createIndex('public', '{{gallery_photo}}', 'public');
        $this->createIndex('comments_count', '{{gallery_photo}}', 'comments_count');
    }

    public function safeDown()
    {
        $this->dropTable('{{gallery_photo}}');
    }
}