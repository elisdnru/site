<?php

class m130328_150817_create_shop_attribute extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{shop_attribute}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'type_id' => 'int(11) NOT NULL',
            'sort' => 'int(11) NOT NULL',
            'alias' => 'varchar(255) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'inshort' => 'tinyint(1) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('type_id', '{{shop_attribute}}', 'type_id');

        $this->createIndex('sort', '{{shop_attribute}}', 'sort');
        $this->createIndex('alias', '{{shop_attribute}}', 'alias');
        $this->createIndex('inshort', '{{shop_attribute}}', 'inshort');
    }

    public function safeDown()
    {
        $this->dropTable('{{shop_attribute}}');
    }
}