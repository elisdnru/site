<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use yii\db\Migration;

class m130717_065918_add_author_link extends Migration
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
