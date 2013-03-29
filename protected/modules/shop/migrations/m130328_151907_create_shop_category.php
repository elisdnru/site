<?php

class m130328_151907_create_shop_category extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{shop_category}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'type_id' => 'int(11) NOT NULL',
            'sort' => 'int(11) NOT NULL',
            'alias' => 'varchar(128) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'text' => 'mediumtext NOT NULL',
            'pagetitle' => 'varchar(255) NOT NULL',
            'description' => 'text NOT NULL',
            'keywords' => 'varchar(255) NOT NULL',
            'parent_id' => 'int(11) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('type_id', '{{shop_category}}', 'type_id');
        $this->createIndex('parent_id', '{{shop_category}}', 'parent_id');

        $this->createIndex('sort', '{{shop_category}}', 'sort');
        $this->createIndex('alias', '{{shop_category}}', 'alias');
    }

    public function safeDown()
    {
        $this->dropTable('{{shop_category}}');
    }
}