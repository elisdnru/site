<?php

class m130328_154120_create_shop_post_type extends EDbMigration
{

    public function safeUp()
    {
        $this->createTable('{{shop_post_type}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'sort' => 'int(11) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'summ' => 'float NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('sort', '{{shop_post_type}}', 'sort');
    }

    public function safeDown()
    {
        $this->dropTable('{{shop_post_type}}');
    }
}