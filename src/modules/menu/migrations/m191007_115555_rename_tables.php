<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use yii\db\Migration;

class m191007_115555_rename_tables extends Migration
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
