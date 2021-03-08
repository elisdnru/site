<?php

use yii\db\Migration;

class m181022_112914_remove_modules_table extends Migration
{
    public function safeUp(): bool
    {
        if ($this->getDb()->getTableSchema('{{module}}')) {
            $this->dropTable('{{module}}');
        }
        return true;
    }

    public function safeDown(): bool
    {
        echo "m181022_112914_remove_modules_table does not support migration down.\n";
        return false;
    }
}
