<?php

class m130328_152812_create_shop_model extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{shop_model}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'title' => 'varchar(255) NOT NULL',
            'product_id' => 'int(11) NOT NULL',
            'image' => 'varchar(255) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('product_id', '{{shop_model}}', 'product_id');
    }

    public function safeDown()
    {
        $this->dropTable('{{shop_model}}');
    }
}