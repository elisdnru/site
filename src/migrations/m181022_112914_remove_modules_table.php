<?php

class m181022_112914_remove_modules_table extends EDbMigration
{
    public function safeUp()
    {
        if ($this->getDbConnection()->getSchema()->getTable('{{module}}')) {
            $this->dropTable('{{module}}');
        }
    }

    public function safeDown()
    {
        echo "m181022_112914_remove_modules_table does not support migration down.\n";
        return false;
    }
}
