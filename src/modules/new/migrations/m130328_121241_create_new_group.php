<?php

class m130328_121241_create_new_group extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{new_group}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'title' => 'varchar(255) NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
    }

    public function safeDown()
    {
        $this->dropTable('{{new_group}}');
    }
}
