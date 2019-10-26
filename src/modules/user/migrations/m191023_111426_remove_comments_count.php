<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use app\extensions\migrate\EDbMigration;

class m191023_111426_remove_comments_count extends EDbMigration
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
