<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use app\extensions\migrate\EDbMigration;

class m191007_115556_rename_tables extends EDbMigration
{
    public function safeUp()
    {
        $this->renameTable('{{page}}', 'pages');
    }

    public function safeDown()
    {
        $this->renameTable('pages', '{{page}}');
    }
}
