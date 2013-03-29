<?php

class m130328_115629_create_new extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{new}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'date' => 'datetime NOT NULL',
            'page_id' => 'int(11) NOT NULL',
            'author_id' => 'int(11) NOT NULL',
            'alias' => 'varchar(255) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'pagetitle' => 'varchar(255) NOT NULL',
            'description' => 'text NOT NULL',
            'keywords' => 'varchar(255) NOT NULL',
            'short' => 'text NOT NULL',
            'short_purified' => 'text NOT NULL',
            'text' => 'mediumtext NOT NULL',
            'text_purified' => 'mediumtext NOT NULL',
            'image' => 'varchar(255) NOT NULL',
            'image_width' => 'int(11) NOT NULL',
            'image_height' => 'int(11) NOT NULL',
            'image_alt' => 'varchar(255) NOT NULL',
            'image_show' => 'smallint(1) NOT NULL',
            'gallery_id' => 'int(11) NOT NULL',
            'group_id' => 'int(11) NOT NULL',
            'public' => 'tinyint(1) NOT NULL',
            'inhome' => 'tinyint(1) NOT NULL',
            'important' => 'tinyint(1) NOT NULL',
            'actual' => 'tinyint(1) NOT NULL',
            'comments_count' => 'int(11) NOT NULL',
            'comments_new_count' => 'int(11) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('page_id', '{{new}}', 'page_id');
        $this->createIndex('gallery_id', '{{new}}', 'gallery_id');
        $this->createIndex('group_id', '{{new}}', 'group_id');
        $this->createIndex('author_id', '{{new}}', 'author_id');

        $this->createIndex('date', '{{new}}', 'date');
        $this->createIndex('alias', '{{new}}', 'alias');
        $this->createIndex('public', '{{new}}', 'public');
        $this->createIndex('inhome', '{{new}}', 'inhome');
        $this->createIndex('important', '{{new}}', 'important');
        $this->createIndex('actual', '{{new}}', 'actual');
        $this->createIndex('comments_count', '{{new}}', 'comments_count');

        $this->createTable('{{new_lang}}', array(
            'l_id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'owner_id' => 'int(11) NOT NULL',
            'lang_id' => 'varchar(6) NOT NULL',
            'l_title' => 'varchar(255) NOT NULL',
            'l_short' => 'text NOT NULL',
            'l_short_purified' => 'text NOT NULL',
            'l_text' => 'mediumtext NOT NULL',
            'l_text_purified' => 'mediumtext NOT NULL',
            'l_pagetitle' => 'varchar(255) NOT NULL',
            'l_description' => 'text NOT NULL',
            'l_keywords' => 'varchar(255) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('lang_id', '{{new_lang}}', 'lang_id');
        $this->createIndex('owner_id', '{{new_lang}}', 'owner_id');

        $this->addForeignKey('new_lang_owner', '{{new_lang}}', 'owner_id', '{{new}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('new_lang_owner', '{{new_lang}}');

        $this->dropTable('{{new_lang}}');
        $this->dropTable('{{new}}');
    }
}