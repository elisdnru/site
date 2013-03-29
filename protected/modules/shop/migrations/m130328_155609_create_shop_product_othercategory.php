<?php

class m130328_155609_create_shop_product_othercategory extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{shop_product_othercategory}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'product_id' => 'int(11) NOT NULL',
            'category_id' => 'int(11) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('product_id', '{{shop_product_othercategory}}', 'product_id');
        $this->createIndex('category_id', '{{shop_product_othercategory}}', 'category_id');
    }

    public function safeDown()
    {
        $this->dropTable('{{shop_product_othercategory}}');
    }
}