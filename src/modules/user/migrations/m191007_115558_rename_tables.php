<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use app\extensions\migrate\EDbMigration;

class m191007_115558_rename_tables extends EDbMigration
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
