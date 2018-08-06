<?php

class m130328_112914_create_module extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{module}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'module' => 'varchar(255) NOT NULL',
            'system' => 'tinyint(1) NOT NULL',
            'installed' => 'tinyint(1) NOT NULL',
            'active' => 'tinyint(1) NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
    }

    public function safeDown()
    {
        $this->dropTable('{{module}}');
    }
}
