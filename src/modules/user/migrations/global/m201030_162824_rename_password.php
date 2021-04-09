<?php

use yii\db\Migration;

class m201030_162824_rename_password extends Migration
{
    public function safeUp(): bool
    {
        $this->renameColumn('users', 'password', 'password_hash');
        return true;
    }

    public function safeDown(): bool
    {
        $this->renameColumn('users', 'password_hash', 'password');
        return true;
    }
}
