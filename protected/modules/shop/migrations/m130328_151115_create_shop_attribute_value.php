<?php

class m130328_151115_create_shop_attribute_value extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{shop_attribute_value}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'product_id' => 'int(11) NOT NULL',
            'attribute_id' => 'int(11) NOT NULL',
            'value' => 'mediumtext NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('product_id', '{{shop_attribute_value}}', 'product_id');
        $this->createIndex('attribute_id', '{{shop_attribute_value}}', 'attribute_id');

        $this->createIndex('value', '{{shop_attribute_value}}', 'value(64)');
    }

    public function safeDown()
    {
        $this->dropTable('{{shop_attribute_value}}');
    }
}