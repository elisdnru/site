<?php

class m130328_141725_create_attribute extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{attribute}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'class' => 'varchar(255) NOT NULL',
            'sort' => 'int(11) NOT NULL',
            'name' => 'varchar(255) NOT NULL',
            'label' => 'varchar(255) NOT NULL',
            'type' => 'varchar(255) NOT NULL',
            'rule' => 'varchar(255) NOT NULL',
            'required' => 'tinyint(1) NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('class', '{{attribute}}', 'class');
        $this->createIndex('sort', '{{attribute}}', 'sort');
    }

    public function safeDown()
    {
        $this->dropTable('{{attribute}}');
    }
}
