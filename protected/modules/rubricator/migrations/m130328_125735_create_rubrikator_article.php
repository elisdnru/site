<?php

class m130328_125735_create_rubrikator_article extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{rubrikator_article}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'category_id' => 'int(11) NOT NULL',
            'date' => 'datetime NOT NULL',
            'alias' => 'varchar(255) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'short' => 'text NOT NULL',
            'short_purified' => 'text NOT NULL',
            'text' => 'mediumtext NOT NULL',
            'text_purified' => 'mediumtext NOT NULL',
            'image' => 'varchar(255) NOT NULL',
            'image_width' => 'int(11) NOT NULL',
            'image_height' => 'int(11) NOT NULL',
            'image_alt' => 'varchar(255) NOT NULL',
            'gallery_id' => 'int(11) NOT NULL',
            'articles_newspage_id' => 'int(11) NOT NULL',
            'photos_newspage_id' => 'int(11) NOT NULL',
            'videos_newspage_id' => 'int(11) NOT NULL',
            'pagetitle' => 'varchar(255) NOT NULL',
            'description' => 'text NOT NULL',
            'keywords' => 'varchar(255) NOT NULL',
            'public' => 'tinyint(1) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('category_id', '{{rubrikator_article}}', 'category_id');
        $this->createIndex('articles_newspage_id', '{{rubrikator_article}}', 'articles_newspage_id');
        $this->createIndex('photos_newspage_id', '{{rubrikator_article}}', 'photos_newspage_id');
        $this->createIndex('videos_newspage_id', '{{rubrikator_article}}', 'videos_newspage_id');

        $this->createIndex('date', '{{rubrikator_article}}', 'date');
        $this->createIndex('alias', '{{rubrikator_article}}', 'alias');
        $this->createIndex('public', '{{rubrikator_article}}', 'public');

        $this->createTable('{{rubrikator_article_lang}}', array(
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

        $this->createIndex('lang_id', '{{rubrikator_article_lang}}', 'lang_id');
        $this->createIndex('owner_id', '{{rubrikator_article_lang}}', 'owner_id');

        $this->addForeignKey('rubrikator_article_lang_owner', '{{rubrikator_article_lang}}', 'owner_id', '{{rubrikator_article}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('rubrikator_article_lang_owner', '{{rubrikator_article_lang}}');

        $this->dropTable('{{rubrikator_article_lang}}');
        $this->dropTable('{{rubrikator_article}}');
    }
}