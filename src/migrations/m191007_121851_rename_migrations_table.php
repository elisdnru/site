<?php

use yii\db\Migration;

class m191007_121851_rename_migrations_table extends Migration
{
    public function safeUp(): bool
    {
        if ($this->getDb()->getTableSchema('{{migration}}')) {
            $this->renameTable('{{migration}}', 'migrations');
            $this->execute('CREATE OR REPLACE VIEW {{migration}} AS SELECT * FROM migrations');
        }
        return true;
    }

    public function safeDown():bool
    {
        $this->execute('DROP VIEW {{migration}}');
        $this->renameTable('migrations', '{{migration}}');
        return true;
    }
}
