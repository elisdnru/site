<?php

class m130328_152519_create_shop_image extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{shop_image}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'product_id' => 'int(11) NOT NULL',
            'file' => 'varchar(255) NOT NULL',
            'main' => 'tinyint(1) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('product_id', '{{shop_image}}', 'product_id');

        $this->createIndex('main', '{{shop_image}}', 'main');
    }

    public function safeDown()
    {
        $this->dropTable('{{shop_image}}');
    }
}