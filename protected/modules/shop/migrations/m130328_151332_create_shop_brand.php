<?php

class m130328_151332_create_shop_brand extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{shop_brand}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'type_id' => 'int(11) NOT NULL',
            'sort' => 'int(11) NOT NULL',
            'alias' => 'varchar(128) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'text' => 'mediumtext NOT NULL',
            'pagetitle' => 'varchar(255) NOT NULL',
            'description' => 'text NOT NULL',
            'keywords' => 'varchar(255) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('type_id', '{{shop_brand}}', 'type_id');

        $this->createIndex('sort', '{{shop_brand}}', 'sort');
        $this->createIndex('alias', '{{shop_brand}}', 'alias');
    }

    public function safeDown()
    {
        $this->dropTable('{{shop_brand}}');
    }
}