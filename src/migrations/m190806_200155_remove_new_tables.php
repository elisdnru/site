<?php

use yii\db\Migration;

class m190806_200155_remove_new_tables extends Migration
{
    public function safeUp(): bool
    {
        if ($this->getDb()->getTableSchema('{{new}}')) {
            $this->dropTable('{{new_page}}');
            $this->dropTable('{{new_group}}');
            $this->dropTable('{{new}}');
        }
        return true;
    }

    public function safeDown(): bool
    {
        echo "m190806_200155_remove_new_tables does not support migration down.\n";
        return false;
    }
}
