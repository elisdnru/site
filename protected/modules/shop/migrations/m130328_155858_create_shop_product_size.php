<?php

class m130328_155858_create_shop_product_size extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{shop_product_size}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'product_id' => 'int(11) NOT NULL',
            'size_id' => 'int(11) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('product_id', '{{shop_product_size}}', 'product_id');
        $this->createIndex('size_id', '{{shop_product_size}}', 'size_id');
    }

    public function safeDown()
    {
        $this->dropTable('{{shop_product_size}}');
    }
}