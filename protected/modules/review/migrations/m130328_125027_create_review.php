<?php

class m130328_125027_create_review extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{review}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'date' => 'datetime NOT NULL',
            'name' => 'varchar(255) NOT NULL',
            'email' => 'varchar(255) NOT NULL',
            'text' => 'text NOT NULL',
            'text_purified' => 'text NOT NULL',
            'public' => 'tinyint(1) NOT NULL',
            'moder' => 'tinyint(1) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('date', '{{review}}', 'date');
        $this->createIndex('public', '{{review}}', 'public');
        $this->createIndex('moder', '{{review}}', 'moder');
    }

    public function safeDown()
    {
        $this->dropTable('{{review}}');
    }
}