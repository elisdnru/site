<?php

class m130328_141957_create_attribute_value extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{attribute_value}}', array(
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'owner_id' => 'int(11) NOT NULL',
            'attribute_id' => 'int(11) NOT NULL',
            'value' => 'mediumtext NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('owner_id', '{{attribute_value}}', 'owner_id');
        $this->createIndex('attribute_id', '{{attribute_value}}', 'attribute_id');

        $this->createIndex('value', '{{attribute_value}}', 'value(64)');
    }

    public function safeDown()
    {
        $this->dropTable('{{attribute_value}}');
    }
}