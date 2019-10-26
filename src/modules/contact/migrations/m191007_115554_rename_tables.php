<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use app\extensions\migrate\EDbMigration;

class m191007_115554_rename_tables extends EDbMigration
{
    public function safeUp()
    {
        $this->renameTable('{{contact}}', 'contacts');
    }

    public function safeDown()
    {
        $this->renameTable('contacts', '{{contact}}');
    }
}
