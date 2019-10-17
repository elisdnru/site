<?php

use app\extensions\migrate\EDbMigration;

class m191017_160126_change_salt extends EDbMigration
{
    public function safeUp()
    {
        $this->alterColumn('users', 'salt', 'varchar(255) DEFAULT NULL');
    }

    public function safeDown()
    {
        $this->alterColumn('users', 'salt', 'varchar(255) NOT NULL');
    }
}
