<?php

use yii\db\Migration;

class m201030_155612_remove_middlename extends Migration
{
    public function safeUp(): bool
    {
        $this->dropColumn('users', 'middlename');
        return true;
    }

    public function safeDown(): bool
    {
        $this->addColumn('{{user}}', 'middlename', 'varchar(255) DEFAULT NULL');
        return true;
    }
}