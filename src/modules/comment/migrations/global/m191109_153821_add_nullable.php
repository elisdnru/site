<?php

use yii\db\Migration;

class m191109_153821_add_nullable extends Migration
{
    public function safeUp(): bool
    {
        $this->alterColumn('comments', 'name', 'varchar(255) DEFAULT NULL');
        $this->alterColumn('comments', 'email', 'varchar(255) DEFAULT NULL');
        $this->alterColumn('comments', 'site', 'varchar(255) DEFAULT NULL');

        $this->update('comments', ['name' => null], ['name' => '']);
        $this->update('comments', ['email' => null], ['email' => '']);
        $this->update('comments', ['site' => null], ['site' => '']);
        return true;
    }

    public function safeDown(): bool
    {
        return false;
    }
}
