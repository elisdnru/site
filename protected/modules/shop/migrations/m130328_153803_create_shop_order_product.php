<?php

class m130328_153803_create_shop_order_product extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{shop_order_product}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'order_id' => 'int(11) NOT NULL',
            'product_id' => 'int(11) NOT NULL',
            'artikul' => 'varchar(255) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'price' => 'float NOT NULL',
            'count' => 'smallint(6) NOT NULL',
            'comment' => 'varchar(255) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('order_id', '{{shop_order_product}}', 'order_id');
        $this->createIndex('product_id', '{{shop_order_product}}', 'product_id');
    }

    public function safeDown()
    {
        $this->dropTable('{{shop_order_product}}');
    }
}