<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use app\extensions\migrate\EDbMigration;

class m191010_181652_add_styles extends EDbMigration
{
    public function safeUp()
    {
        $this->addColumn('pages', 'styles', 'TEXT DEFAULT NULL');
    }

    public function safeDown()
    {
        $this->dropColumn('pages', 'styles');
    }
}
