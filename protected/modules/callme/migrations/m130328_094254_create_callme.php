<?php

class m130328_094254_create_callme extends EDbMigration
{
	public function safeUp()
    {
        $this->createTable('{{callme}}', array(
            'id' => 'smallint(6) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'date' => 'datetime NOT NULL',
            'name' => 'varchar(200) NOT NULL',
            'phone' => 'varchar(100) NOT NULL',
            'text' => 'text NOT NULL',
            'readed' => 'tinyint(1) NOT NULL',
            'called' => 'tinyint(1) NOT NULL',
        ), 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('date', '{{callme}}', 'date');
	}

	public function safeDown()
	{
		$this->dropTable('{{callme}}');
	}
}