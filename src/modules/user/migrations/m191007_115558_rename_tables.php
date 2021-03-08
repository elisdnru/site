<?php

use yii\db\Migration;

class m191007_115558_rename_tables extends Migration
{
    public function safeUp(): bool
    {
        $this->renameTable('{{user}}', 'users');
        return true;
    }

    public function safeDown(): bool
    {
        $this->renameTable('users', '{{user}}');
        return true;
    }
}
