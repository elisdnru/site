<?php

use yii\db\Migration;

class m201030_165531_rename_name extends Migration
{
    public function safeUp(): bool
    {
        $this->renameColumn('users', 'name', 'firstname');
        return true;
    }

    public function safeDown(): bool
    {
        $this->renameColumn('users', 'firstname', 'name');
        return true;
    }
}
