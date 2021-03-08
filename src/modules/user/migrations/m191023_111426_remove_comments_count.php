<?php

use yii\db\Migration;

class m191023_111426_remove_comments_count extends Migration
{
    public function safeUp(): bool
    {
        $this->dropColumn('users', 'comments_count');
        return true;
    }

    public function safeDown(): bool
    {
        return false;
    }
}
