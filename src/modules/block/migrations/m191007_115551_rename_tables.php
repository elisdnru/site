<?php

use app\extensions\migrate\EDbMigration;

class m191007_115551_rename_tables extends EDbMigration
{
    public function safeUp()
    {
        $this->renameTable('{{block}}', 'blocks');
    }

    public function safeDown()
    {
        $this->renameTable('blocks', '{{block}}');
    }
}
