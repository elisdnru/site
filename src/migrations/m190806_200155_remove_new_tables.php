<?php

class m190806_200155_remove_new_tables extends EDbMigration
{
    public function safeUp()
    {
        if ($this->getDbConnection()->getSchema()->getTable('{{new}}')) {
            $this->dropTable('{{new_page}}');
            $this->dropTable('{{new_group}}');
            $this->dropTable('{{new}}');
        }
    }

    public function safeDown()
    {
        echo "m190806_200155_remove_new_tables does not support migration down.\n";
        return false;
    }
}
