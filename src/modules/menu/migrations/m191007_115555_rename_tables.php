<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use app\extensions\migrate\EDbMigration;

class m191007_115555_rename_tables extends EDbMigration
{
    public function safeUp()
    {
        $this->renameTable('{{menu}}', 'menu_items');
    }

    public function safeDown()
    {
        $this->renameTable('menu_items', '{{menu}}');
    }
}
