<?php

class m130328_121249_create_new_page extends EDbMigration
{
    public function safeUp()
    {
        $this->createTable('{{new_page}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'page_id' => 'int(11) NOT NULL',
            'list_layout' => 'varchar(255) NOT NULL',
            'show_layout' => 'varchar(255) NOT NULL',
            'show_view' => 'varchar(255) NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('page_id', '{{new_page}}', 'page_id');
    }

    public function safeDown()
    {
        $this->dropTable('{{new_page}}');
    }
}
