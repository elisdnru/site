<?php

use yii\db\Migration;

class m190918_143321_added_nullable extends Migration
{
    public function safeUp(): bool
    {
        $this->alterColumn('{{user}}', 'last_visit_datetime', 'datetime DEFAULT NULL');
        return true;
    }

    public function safeDown(): bool
    {
        $this->alterColumn('{{user}}', 'last_visit_datetime', 'datetime NOT NULL');
        return true;
    }
}