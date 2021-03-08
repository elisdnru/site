<?php

use yii\db\Migration;

class m191017_160126_change_salt extends Migration
{
    public function safeUp(): bool
    {
        $this->alterColumn('users', 'salt', 'varchar(255) DEFAULT NULL');
        return true;
    }

    public function safeDown(): bool
    {
        $this->alterColumn('users', 'salt', 'varchar(255) NOT NULL');
        return true;
    }
}
