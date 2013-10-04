<?php

class m130904_103601_create_gallery_category extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{gallery_category}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'sort' => 'int(11) NOT NULL',
            'alias' => 'varchar(255) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'text' => 'mediumtext NOT NULL',
            'image' => 'varchar(255) NOT NULL',
            'image_width' => 'int(11) NOT NULL',
            'image_height' => 'int(11) NOT NULL',
            'pagetitle' => 'varchar(255) NOT NULL',
            'description' => 'text NOT NULL',
            'keywords' => 'varchar(255) NOT NULL',
            'parent_id' => 'int(11) NOT NULL',
        ), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8');

        $this->createIndex('parent_id', '{{gallery_category}}', 'parent_id');

        $this->createIndex('sort', '{{gallery_category}}', 'sort');
        $this->createIndex('alias', '{{gallery_category}}', 'alias');
    }

    public function safeDown()
    {
        $this->dropTable('{{gallery_category}}');
    }
}