<?php

use app\extensions\migrate\EDbMigration;

class m191007_115553_rename_tables extends EDbMigration
{
    public function safeUp()
    {
        $this->renameTable('{{comment}}', 'comments');
    }

    public function safeDown()
    {
        $this->renameTable('comments', '{{comment}}');
    }
}
