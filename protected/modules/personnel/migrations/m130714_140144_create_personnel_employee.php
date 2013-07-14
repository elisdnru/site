<?php

class m130714_140144_create_personnel_employee extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{personnel_employee}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'sort' => 'int(11) NOT NULL',
            'category_id' => 'int(11) NOT NULL',
            'alias' => 'varchar(255) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'short' => 'text NOT NULL',
            'short_purified' => 'text NOT NULL',
            'text' => 'mediumtext NOT NULL',
            'text_purified' => 'mediumtext NOT NULL',
            'pagetitle' => 'varchar(255) NOT NULL',
            'description' => 'text NOT NULL',
            'keywords' => 'varchar(255) NOT NULL',
            'image' => 'varchar(255) NOT NULL',
            'image_width' => 'int(11) NOT NULL',
            'image_height' => 'int(11) NOT NULL',
            'image_show' => 'tinyint(1) NOT NULL',
            'public' => 'tinyint(1) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('category_id', '{{personnel_employee}}', 'category_id');

        $this->createIndex('sort', '{{personnel_employee}}', 'sort');
        $this->createIndex('alias', '{{personnel_employee}}', 'alias');
        $this->createIndex('public', '{{personnel_employee}}', 'public');

        $this->createTable('{{personnel_employee_lang}}', array(
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

        $this->createIndex('lang_id', '{{personnel_employee_lang}}', 'lang_id');
        $this->createIndex('owner_id', '{{personnel_employee_lang}}', 'owner_id');

        $this->addForeignKey('personnel_employee_lang_owner', '{{personnel_employee_lang}}', 'owner_id', '{{personnel_employee}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('personnel_employee_lang_owner', '{{personnel_employee_lang}}');

        $this->dropTable('{{personnel_employee_lang}}');
        $this->dropTable('{{personnel_employee}}');
    }
}