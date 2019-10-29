<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use yii\db\Migration;

class m191007_181351_remove_migrations_view extends Migration
{
    public function safeUp()
    {
        if ($this->getDb()->getTableSchema('{{migration}}')) {
            $this->execute('DROP VIEW {{migration}}');
        }
    }

    public function safeDown()
    {
        $this->execute('CREATE OR REPLACE VIEW {{migration}} AS SELECT * FROM migrations');
    }
}
