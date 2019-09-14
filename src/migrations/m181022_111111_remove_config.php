<?php

class m181022_111111_remove_config extends EDbMigration
{
    public function safeUp()
    {
        if ($this->getDbConnection()->getSchema()->getTable('{{config}}')) {
            $this->dropTable('{{config}}');
        }
    }

    public function safeDown()
    {
        echo "m181022_111111_remove_config does not support migration down.\n";
        return false;
    }
}
