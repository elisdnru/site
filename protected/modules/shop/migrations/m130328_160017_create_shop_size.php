<?php

class m130328_160017_create_shop_size extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{shop_size}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'sort' => 'int(11) NOT NULL',
            'alias' => 'varchar(128) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'text' => 'mediumtext NOT NULL',
            'pagetitle' => 'varchar(255) NOT NULL',
            'description' => 'text NOT NULL',
            'keywords' => 'varchar(255) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('sort', '{{shop_size}}', 'sort');
        $this->createIndex('alias', '{{shop_size}}', 'alias');
    }

    public function safeDown()
    {
        $this->dropTable('{{shop_size}}');
    }
}