<?php

use yii\db\Migration;

class m191007_115556_rename_tables extends Migration
{
    public function safeUp(): bool
    {
        $this->renameTable('{{page}}', 'pages');
        return true;
    }

    public function safeDown(): bool
    {
        $this->renameTable('pages', '{{page}}');
        return true;
    }
}
