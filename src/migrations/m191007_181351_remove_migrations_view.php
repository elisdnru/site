<?php

use yii\db\Migration;

class m191007_181351_remove_migrations_view extends Migration
{
    public function safeUp(): bool
    {
        if ($this->getDb()->getTableSchema('{{migration}}')) {
            $this->execute('DROP VIEW {{migration}}');
        }
        return true;
    }

    public function safeDown(): bool
    {
        $this->execute('CREATE OR REPLACE VIEW {{migration}} AS SELECT * FROM migrations');
        return true;
    }
}
