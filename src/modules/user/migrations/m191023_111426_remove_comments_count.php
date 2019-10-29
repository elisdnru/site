<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use yii\db\Migration;

class m191023_111426_remove_comments_count extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('users', 'comments_count');
    }

    public function safeDown(): bool
    {
        return false;
    }
}
