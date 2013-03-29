<?php

class m130328_123717_create_recipe extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{recipe}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'date' => 'datetime NOT NULL',
            'alias' => 'varchar(255) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'short' => 'text NOT NULL',
            'short_purified' => 'text NOT NULL',
            'text' => 'mediumtext NOT NULL',
            'text_purified' => 'mediumtext NOT NULL',
            'image' => 'varchar(255) NOT NULL',
            'imagealt' => 'varchar(255) NOT NULL',
            'gallery_id' => 'int(11) NOT NULL',
            'pagetitle' => 'varchar(255) NOT NULL',
            'description' => 'text NOT NULL',
            'keywords' => 'varchar(255) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('gallery_id', '{{recipe}}', 'gallery_id');

        $this->createIndex('date', '{{recipe}}', 'date');
        $this->createIndex('alias', '{{recipe}}', 'alias');

        $this->createTable('{{recipe_lang}}', array(
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

        $this->createIndex('lang_id', '{{recipe_lang}}', 'lang_id');
        $this->createIndex('owner_id', '{{recipe_lang}}', 'owner_id');

        $this->addForeignKey('recipe_lang_owner', '{{recipe_lang}}', 'owner_id', '{{recipe}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('recipe_lang_owner', '{{recipe_lang}}');
        $this->dropTable('{{recipe_lang}}');
        $this->dropTable('{{recipe}}');
    }
}