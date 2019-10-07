<?php

use app\extensions\migrate\EDbMigration;

class m191007_121851_rename_migrations_table extends EDbMigration
{
    public function safeUp()
    {
        $this->renameTable('{{migration}}', 'migrations');
        $this->execute('CREATE OR REPLACE VIEW {{migration}} AS SELECT * FROM migrations');
    }

    public function safeDown()
    {
        $this->execute('DROP VIEW {{migration}}');
        $this->renameTable('migrations', '{{migration}}');
    }
}
