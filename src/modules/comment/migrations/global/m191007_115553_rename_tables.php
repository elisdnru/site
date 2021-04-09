<?php

use yii\db\Migration;

class m191007_115553_rename_tables extends Migration
{
    public function safeUp(): bool
    {
        $this->renameTable('{{comment}}', 'comments');
        return true;
    }

    public function safeDown(): bool
    {
        $this->renameTable('comments', '{{comment}}');
        return true;
    }
}
