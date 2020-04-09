<?php

use yii\db\Migration;

class m130328_120429_create_page extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{page}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'layout_id' => 'smallint(6) NOT NULL',
            'layout_subpages_id' => 'smallint(6) NOT NULL',
            'alias' => 'varchar(255) NOT NULL',
            'date' => 'date NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'hidetitle' => 'tinyint(1) NOT NULL',
            'pagetitle' => 'varchar(255) NOT NULL',
            'description' => 'text NOT NULL',
            'keywords' => 'varchar(255) NOT NULL',
            'text' => 'mediumtext NOT NULL',
            'text_purified' => 'mediumtext NOT NULL',
            'image' => 'varchar(255) NOT NULL',
            'image_width' => 'varchar(255) NOT NULL',
            'image_height' => 'varchar(255) NOT NULL',
            'image_alt' => 'varchar(255) NOT NULL',
            'system' => 'tinyint(1) NOT NULL',
            'parent_id' => 'int(11) NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('layout_id', '{{page}}', 'layout_id');
        $this->createIndex('layout_subpages_id', '{{page}}', 'layout_subpages_id');
        $this->createIndex('parent_id', '{{page}}', 'parent_id');

        $this->createIndex('alias', '{{page}}', 'alias');
        $this->createIndex('date', '{{page}}', 'date');
        $this->createIndex('system', '{{page}}', 'system');

        $this->createTable('{{page_lang}}', [
            'l_id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'owner_id' => 'int(11) NOT NULL',
            'lang_id' => 'varchar(6) NOT NULL',
            'l_title' => 'varchar(255) NOT NULL',
            'l_text' => 'mediumtext NOT NULL',
            'l_text_purified' => 'mediumtext NOT NULL',
            'l_pagetitle' => 'varchar(255) NOT NULL',
            'l_description' => 'text NOT NULL',
            'l_keywords' => 'varchar(255) NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('lang_id', '{{page_lang}}', 'lang_id');
        $this->createIndex('owner_id', '{{page_lang}}', 'owner_id');

        $this->addForeignKey('page_lang_owner', '{{page_lang}}', 'owner_id', '{{page}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('page_lang_owner', '{{page_lang}}');

        $this->dropTable('{{page_lang}}');
        $this->dropTable('{{page}}');
    }
}
