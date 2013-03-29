<?php

class m130328_160138_create_shop_type extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{shop_type}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'sort' => 'int(11) NOT NULL',
            'alias' => 'varchar(128) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'text' => 'mediumtext NOT NULL',
            'image' => 'varchar(255) NOT NULL',
            'pagetitle' => 'varchar(255) NOT NULL',
            'description' => 'text NOT NULL',
            'keywords' => 'varchar(255) NOT NULL',
            'visible' => 'tinyint(1) NOT NULL DEFAULT 1',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('sort', '{{shop_type}}', 'sort');
        $this->createIndex('alias', '{{shop_type}}', 'alias');
        $this->createIndex('visible', '{{shop_type}}', 'visible');
    }

    public function safeDown()
    {
        $this->dropTable('{{shop_type}}');
    }
}