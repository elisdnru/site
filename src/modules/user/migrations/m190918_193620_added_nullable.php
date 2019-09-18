<?php

use app\extensions\migrate\EDbMigration;

class m190918_193620_added_nullable extends EDbMigration
{
    public function safeUp()
    {
        $this->alterColumn('{{user}}', 'identity', 'varchar(255) DEFAULT NULL');
        $this->alterColumn('{{user}}', 'network', 'varchar(255) DEFAULT NULL');
        $this->alterColumn('{{user}}', 'confirm', 'varchar(255) DEFAULT NULL');
        $this->alterColumn('{{user}}', 'avatar', 'varchar(255) DEFAULT NULL');
        $this->alterColumn('{{user}}', 'site', 'varchar(255) DEFAULT NULL');
    }

    public function safeDown()
    {
        $this->alterColumn('{{user}}', 'identity', 'varchar(255) NOT NULL');
        $this->alterColumn('{{user}}', 'network', 'varchar(255) NOT NULL');
        $this->alterColumn('{{user}}', 'confirm', 'varchar(255) NOT NULL');
        $this->alterColumn('{{user}}', 'avatar', 'varchar(255) NOT NULL');
        $this->alterColumn('{{user}}', 'site', 'varchar(255) NOT NULL');
        $this->alterColumn('{{user}}', 'confirm', 'varchar(255) NOT NULL');
    }
}
