<?php

use app\extensions\migrate\EDbMigration;

class m191007_181351_remove_migrations_view extends EDbMigration
{
    public function safeUp()
    {
        if ($this->getDbConnection()->getSchema()->getTable('{{migration}}')) {
            $this->execute('DROP VIEW {{migration}}');
        }
    }

    public function safeDown()
    {
        $this->execute('CREATE OR REPLACE VIEW {{migration}} AS SELECT * FROM migrations');
    }
}
