<?php

use app\extensions\migrate\EDbMigration;

class m191007_110105_remove_page extends EDbMigration
{
    public function safeUp()
    {
        $this->dropTable('{{user_page}}');
    }

    public function safeDown()
    {
        $this->createTable('{{user_page}}', [
            'id' => 'int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'user_id' => 'int(11) NOT NULL',
            'page_id' => 'int(11) NOT NULL',
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('user_id', '{{user_page}}', 'user_id');
        $this->createIndex('page_id', '{{user_page}}', 'page_id');
    }
}
