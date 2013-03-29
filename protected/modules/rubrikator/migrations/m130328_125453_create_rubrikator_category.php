<?php

class m130328_125453_create_rubrikator_category extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{rubrikator_category}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'sort' => 'int(11) NOT NULL',
            'alias' => 'varchar(255) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'text' => 'mediumtext NOT NULL',
            'image' => 'varchar(255) NOT NULL',
            'pagetitle' => 'varchar(255) NOT NULL',
            'description' => 'text NOT NULL',
            'keywords' => 'varchar(255) NOT NULL',
        ), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8');

        $this->createIndex('sort', '{{rubrikator_category}}', 'sort');
        $this->createIndex('alias', '{{rubrikator_category}}', 'alias');

        $this->createTable('{{rubrikator_category_lang}}', array(
            'l_id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'owner_id' => 'int(11) NOT NULL',
            'lang_id' => 'varchar(6) NOT NULL',
            'l_title' => 'varchar(255) NOT NULL',
            'l_text' => 'mediumtext NOT NULL',
            'l_pagetitle' => 'varchar(255) NOT NULL',
            'l_description' => 'text NOT NULL',
            'l_keywords' => 'varchar(255) NOT NULL',
        ), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8');

        $this->createIndex('lang_id', '{{rubrikator_category_lang}}', 'lang_id');
        $this->createIndex('owner_id', '{{rubrikator_category_lang}}', 'owner_id');

        $this->addForeignKey('rubrikator_category_lang_owner', '{{rubrikator_category_lang}}', 'owner_id', '{{rubrikator_category}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('rubrikator_category_lang_owner', '{{rubrikator_category_lang}}');

        $this->dropTable('{{rubrikator_category}}');
        $this->dropTable('{{rubrikator_category_lang}}');
    }
}