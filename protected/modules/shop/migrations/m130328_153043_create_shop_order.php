<?php

class m130328_153043_create_shop_order extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{shop_order}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'date' => 'datetime NOT NULL',
            'user_id' => 'int(11) NOT NULL',
            'lastname' => 'varchar(255) NOT NULL',
            'name' => 'varchar(255) NOT NULL',
            'middlename' => 'varchar(255) NOT NULL',
            'zip' => 'varchar(255) NOT NULL',
            'address' => 'text NOT NULL',
            'phone' => 'varchar(255) NOT NULL',
            'email' => 'varchar(255) NOT NULL',
            'comment' => 'text NOT NULL',
            'quickly' => 'tinyint(1) NOT NULL',
            'post_id' => 'int(11) NOT NULL',
            'post_title' => 'varchar(255) NOT NULL',
            'post_sum' => 'float NOT NULL',
            'post_code' => 'varchar(255) NOT NULL',
            'curs' => 'float NOT NULL',
            'apply' => 'tinyint(1) NOT NULL',
            'payed' => 'tinyint(1) NOT NULL',
            'complete' => 'tinyint(1) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('user_id', '{{shop_order}}', 'user_id');
        $this->createIndex('post_id', '{{shop_order}}', 'post_id');

        $this->createIndex('date', '{{shop_order}}', 'date');
        $this->createIndex('quickly', '{{shop_order}}', 'quickly');
        $this->createIndex('apply', '{{shop_order}}', 'apply');
        $this->createIndex('payed', '{{shop_order}}', 'payed');
        $this->createIndex('complete', '{{shop_order}}', 'complete');
    }

    public function safeDown()
    {
        $this->dropTable('{{shop_order}}');
    }
}