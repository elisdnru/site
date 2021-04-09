<?php

use yii\db\Migration;

class m190918_193620_added_nullable extends Migration
{
    public function safeUp(): bool
    {
        $this->alterColumn('{{user}}', 'identity', 'varchar(255) DEFAULT NULL');
        $this->alterColumn('{{user}}', 'network', 'varchar(255) DEFAULT NULL');
        $this->alterColumn('{{user}}', 'confirm', 'varchar(255) DEFAULT NULL');
        $this->alterColumn('{{user}}', 'avatar', 'varchar(255) DEFAULT NULL');
        $this->alterColumn('{{user}}', 'site', 'varchar(255) DEFAULT NULL');
        return true;
    }

    public function safeDown(): bool
    {
        $this->alterColumn('{{user}}', 'identity', 'varchar(255) NOT NULL');
        $this->alterColumn('{{user}}', 'network', 'varchar(255) NOT NULL');
        $this->alterColumn('{{user}}', 'confirm', 'varchar(255) NOT NULL');
        $this->alterColumn('{{user}}', 'avatar', 'varchar(255) NOT NULL');
        $this->alterColumn('{{user}}', 'site', 'varchar(255) NOT NULL');
        $this->alterColumn('{{user}}', 'confirm', 'varchar(255) NOT NULL');
        return true;
    }
}
