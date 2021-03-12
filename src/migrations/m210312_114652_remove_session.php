<?php

use yii\db\Migration;

class m210312_114652_remove_session extends Migration
{
    public function safeUp(): bool
    {
        $this->dropTable('session');
        return true;
    }

    public function safeDown(): bool
    {
        echo "m210312_114652_remove_session does not support migration down.\n";
        return false;
    }
}
