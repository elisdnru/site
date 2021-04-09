<?php

use yii\db\Migration;

class m180806_105836_remove_language_tables extends Migration
{
    public function safeUp(): bool
    {
        $this->dropTable('{{portfolio_work_lang}}');
        $this->dropTable('{{portfolio_category_lang}}');
        return true;
    }

    public function safeDown(): bool
    {
        echo "m180806_105836_remove_language_tables does not support migration down.\n";
        return false;
    }
}
