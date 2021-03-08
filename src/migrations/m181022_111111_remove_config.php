<?php

use yii\db\Migration;

class m181022_111111_remove_config extends Migration
{
    public function safeUp(): bool
    {
        if ($this->getDb()->getTableSchema('{{config}}')) {
            $this->dropTable('{{config}}');
        }
        return true;
    }

    public function safeDown(): bool
    {
        echo "m181022_111111_remove_config does not support migration down.\n";
        return false;
    }
}
