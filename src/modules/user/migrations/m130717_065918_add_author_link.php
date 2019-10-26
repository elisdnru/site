<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use app\extensions\migrate\EDbMigration;

class m130717_065918_add_author_link extends EDbMigration
{
    public function safeUp()
    {
        $this->addColumn('{{user}}', 'googleplus', 'varchar(255) NOT NULL AFTER site');
    }

    public function safeDown()
    {
        $this->dropColumn('{{user}}', 'googleplus');
    }
}
