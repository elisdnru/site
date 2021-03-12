<?php

use yii\db\Migration;

class m180806_105831_remove_language_tables extends Migration
{
    public function safeUp(): bool
    {
        if ($this->getDb()->getTableSchema('{{menu_lang}}')) {
            $this->dropTable('{{menu_lang}}');
        }

        if ($this->getDb()->getTableSchema('{{new_lang}}')) {
            $this->dropTable('{{new_lang}}');
        }

        return true;
    }

    public function safeDown(): bool
    {
        echo "m180806_105831_remove_language_tables does not support migration down.\n";
        return false;
    }
}
