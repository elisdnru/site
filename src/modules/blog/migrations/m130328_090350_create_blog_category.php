<?php

class m130328_090350_create_blog_category extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{blog_category}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'sort' => 'int(11) NOT NULL',
            'alias' => 'varchar(255) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'text' => 'mediumtext NOT NULL',
            'parent_id' => 'int(11) NOT NULL',
            'pagetitle' => 'varchar(255) NOT NULL',
            'description' => 'text NOT NULL',
            'keywords' => 'varchar(255) NOT NULL',
        ], 'ENGINE=InnoDB  DEFAULT CHARSET=utf8');

        $this->createIndex('parent_id', '{{blog_category}}', 'parent_id');

        $this->createIndex('sort', '{{blog_category}}', 'sort');
        $this->createIndex('alias', '{{blog_category}}', 'alias');

        $this->createTable('{{blog_category_lang}}', [
            'l_id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'owner_id' => 'int(11) NOT NULL',
            'lang_id' => 'varchar(6) NOT NULL',
            'l_title' => 'varchar(255) NOT NULL',
            'l_text' => 'mediumtext NOT NULL',
            'l_pagetitle' => 'varchar(255) NOT NULL',
            'l_description' => 'text NOT NULL',
            'l_keywords' => 'varchar(255) NOT NULL',
        ], 'ENGINE=InnoDB  DEFAULT CHARSET=utf8');

        $this->createIndex('lang_id', '{{blog_category_lang}}', 'lang_id');
        $this->createIndex('owner_id', '{{blog_category_lang}}', 'owner_id');

        $this->addForeignKey('blog_category_lang_owner', '{{blog_category_lang}}', 'owner_id', '{{blog_category}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('blog_category_lang_owner', '{{blog_category_lang}}');

        $this->dropTable('{{blog_category}}');
        $this->dropTable('{{blog_category_lang}}');
    }
}
