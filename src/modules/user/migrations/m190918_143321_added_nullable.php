<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use app\extensions\migrate\EDbMigration;

class m190918_143321_added_nullable extends EDbMigration
{
    public function safeUp()
    {
        $this->alterColumn('{{user}}', 'last_visit_datetime', 'datetime DEFAULT NULL');
    }

    public function safeDown()
    {
        $this->alterColumn('{{user}}', 'last_visit_datetime', 'datetime NOT NULL');
    }
}
