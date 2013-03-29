<?php

class m130328_111111_create_config extends EDbMigration
{
	public function safeUp()
	{
        $this->createTable('{{config}}', array(
            'id' => 'int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'param' => 'varchar(128) NOT NULL',
            'value' => 'text NOT NULL',
            'label' => 'varchar(255) NOT NULL',
            'type' => 'varchar(128) NOT NULL',
            'default' => 'text NOT NULL',
            'variants' => 'text NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('param', '{{config}}', 'param', true);
	}

	public function safeDown()
	{
		$this->dropTable('{{config}}');
    }
}