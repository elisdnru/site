<?php

use yii\db\Migration;

class m191007_115558_rename_tables extends Migration
{
    public function safeUp()
    {
        $this->renameTable('{{user}}', 'users');
    }

    public function safeDown()
    {
        $this->renameTable('users', '{{user}}');
    }
}
