<?php

use yii\db\Migration;

class m180806_105832_remove_language_tables extends Migration
{
    public function safeUp(): bool
    {
        $this->dropTable('{{block_lang}}');
        return true;
    }

    public function safeDown(): bool
    {
        echo "m180806_105832_remove_language_tables does not support migration down.\n";
        return false;
    }
}