<?php

class m181022_141825_remove_unused_blocks extends EDbMigration
{
    public function safeUp()
    {
        if (!$this->getDbConnection()->getSchema()->getTable('{{block}}')) {
            return;
        }

        $this->delete('{{block}}', ['in', 'alias', [
            'header',
            'footer',
            'copyright',
        ]]);
    }

    public function safeDown()
    {
        echo "m180806_112238_remove_unused_configs does not support migration down.\n";
        return false;
    }
}
