<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use yii\db\Migration;

class m191007_115554_rename_tables extends Migration
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
