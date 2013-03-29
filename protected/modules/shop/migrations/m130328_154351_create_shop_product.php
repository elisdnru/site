<?php

class m130328_154351_create_shop_product extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{shop_product}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'artikul' => 'varchar(128) NOT NULL',
            'type_id' => 'int(11) NOT NULL',
            'category_id' => 'int(11) NOT NULL',
            'brand_id' => 'int(11) NOT NULL',
            'color_id' => 'int(11) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'weight' => 'varchar(255) NOT NULL',
            'quality' => 'varchar(255) NOT NULL',
            'short' => 'varchar(255) NOT NULL',
            'text' => 'text NOT NULL',
            'text_purified' => 'text NOT NULL',
            'price' => 'float NOT NULL',
            'count' => 'int(11) NOT NULL',
            'public' => 'tinyint(1) NOT NULL',
            'inhome' => 'tinyint(1) NOT NULL',
            'priority' => 'smallint(6) NOT NULL',
            'popular' => 'tinyint(1) NOT NULL',
            'sale' => 'tinyint(1) NOT NULL',
            'rating' => 'float NOT NULL',
            'rating_count' => 'int(11) NOT NULL',
            'rating_summ' => 'int(11) NOT NULL',
            'pagetitle' => 'varchar(255) NOT NULL',
            'description' => 'varchar(255) NOT NULL',
            'keywords' => 'varchar(255) NOT NULL',
            'rubrika_id' => 'int(11) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('type_id', '{{shop_product}}', 'type_id');
        $this->createIndex('category_id', '{{shop_product}}', 'category_id');
        $this->createIndex('brand_id', '{{shop_product}}', 'brand_id');
        $this->createIndex('color_id', '{{shop_product}}', 'color_id');
        $this->createIndex('rubrika_id', '{{shop_product}}', 'rubrika_id');

        $this->createIndex('artikul', '{{shop_product}}', 'artikul');
        $this->createIndex('quality', '{{shop_product}}', 'quality');
        $this->createIndex('public', '{{shop_product}}', 'public');
        $this->createIndex('inhome', '{{shop_product}}', 'inhome');
        $this->createIndex('priority', '{{shop_product}}', 'priority');
        $this->createIndex('popular', '{{shop_product}}', 'popular');
        $this->createIndex('sale', '{{shop_product}}', 'sale');
    }

    public function safeDown()
    {
        $this->dropTable('{{shop_product}}');
    }
}