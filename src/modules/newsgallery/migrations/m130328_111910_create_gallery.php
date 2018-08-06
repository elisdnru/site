<?php

class m130328_111910_create_gallery extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{gallery}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'title' => 'varchar(255) NOT NULL',
            'alias' => 'varchar(255) NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('alias', '{{gallery}}', 'alias');
    }

    public function safeDown()
    {
        $this->dropTable('{{gallery}}');
    }
}
