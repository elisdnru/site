<?php

class m130328_084945_create_blog_post extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{blog_post}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'date' => 'datetime NOT NULL',
            'update_date' => 'datetime NOT NULL',
            'category_id' => 'int(11) NOT NULL',
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
            'comments_count' => 'int(11) NOT NULL',
            'comments_new_count' => 'int(11) NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('category_id', '{{blog_post}}', 'category_id');
        $this->createIndex('gallery_id', '{{blog_post}}', 'gallery_id');
        $this->createIndex('group_id', '{{blog_post}}', 'group_id');
        $this->createIndex('author_id', '{{blog_post}}', 'author_id');

        $this->createIndex('date', '{{blog_post}}', 'date');
        $this->createIndex('alias', '{{blog_post}}', 'alias');
        $this->createIndex('public', '{{blog_post}}', 'public');
        $this->createIndex('comments_count', '{{blog_post}}', 'comments_count');

        $this->createTable('{{blog_post_lang}}', [
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
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('lang_id', '{{blog_post_lang}}', 'lang_id');
        $this->createIndex('owner_id', '{{blog_post_lang}}', 'owner_id');

        $this->addForeignKey('blog_post_lang_owner', '{{blog_post_lang}}', 'owner_id', '{{blog_post}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('blog_post_lang_owner', '{{blog_post_lang}}');

        $this->dropTable('{{blog_post}}');
        $this->dropTable('{{blog_post_lang}}');
    }
}
