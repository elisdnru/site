<?php

class m130328_152017_create_shop_brand_category extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{shop_brand_category}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'brand_id' => 'int(11) NOT NULL',
            'category_id' => 'int(11) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('brand_id', '{{shop_brand_category}}', 'brand_id');
        $this->createIndex('category_id', '{{shop_brand_category}}', 'category_id');
    }

    public function safeDown()
    {
        $this->dropTable('{{shop_brand_category}}');
    }
}