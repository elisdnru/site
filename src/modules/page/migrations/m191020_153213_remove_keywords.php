<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use app\extensions\migrate\EDbMigration;

class m191020_153213_remove_keywords extends EDbMigration
{
    public function safeUp()
    {
        $this->dropColumn('pages', 'keywords');
    }

    public function safeDown()
    {
        $this->addColumn('pages', 'keywords', 'varchar(255) DEFAULT NULL');
    }
}
