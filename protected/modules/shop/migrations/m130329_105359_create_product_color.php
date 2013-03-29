<?php

class m130329_105359_create_product_color extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{shop_product_color}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'product_id' => 'int(11) NOT NULL',
            'color_id' => 'int(11) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('product_id', '{{shop_product_color}}', 'product_id');
        $this->createIndex('color_id', '{{shop_product_color}}', 'color_id');
    }

    public function safeDown()
    {
        $this->dropTable('{{shop_product_color}}');
    }
}