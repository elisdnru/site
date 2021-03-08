<?php

use yii\db\Migration;

class m191007_115551_rename_tables extends Migration
{
    public function safeUp(): bool
    {
        $this->renameTable('{{block}}', 'blocks');
        return true;
    }

    public function safeDown(): bool
    {
        $this->renameTable('blocks', '{{block}}');
        return true;
    }
}
