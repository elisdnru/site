<?php

class m130714_140211_create_personnel_category extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{personnel_category}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'sort' => 'int(11) NOT NULL',
            'alias' => 'varchar(255) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'text' => 'mediumtext NOT NULL',
            'parent_id' => 'int(11) NOT NULL',
            'pagetitle' => 'varchar(255) NOT NULL',
            'description' => 'text NOT NULL',
            'keywords' => 'varchar(255) NOT NULL',
        ), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8');

        $this->createIndex('parent_id', '{{personnel_category}}', 'parent_id');

        $this->createIndex('sort', '{{personnel_category}}', 'sort');
        $this->createIndex('alias', '{{personnel_category}}', 'alias');

        $this->createTable('{{personnel_category_lang}}', array(
            'l_id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'owner_id' => 'int(11) NOT NULL',
            'lang_id' => 'varchar(6) NOT NULL',
            'l_title' => 'varchar(255) NOT NULL',
            'l_text' => 'mediumtext NOT NULL',
            'l_pagetitle' => 'varchar(255) NOT NULL',
            'l_description' => 'text NOT NULL',
            'l_keywords' => 'varchar(255) NOT NULL',
        ), 'ENGINE=InnoDB  DEFAULT CHARSET=utf8');

        $this->createIndex('lang_id', '{{personnel_category_lang}}', 'lang_id');
        $this->createIndex('owner_id', '{{personnel_category_lang}}', 'owner_id');

        $this->addForeignKey('personnel_category_lang_owner', '{{personnel_category_lang}}', 'owner_id', '{{personnel_category}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('personnel_category_lang_owner', '{{personnel_category_lang}}');

        $this->dropTable('{{personnel_category_lang}}');
        $this->dropTable('{{personnel_category}}');
    }
}