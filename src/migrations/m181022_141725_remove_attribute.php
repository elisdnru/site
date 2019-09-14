<?php

class m181022_141725_remove_attribute extends EDbMigration
{
    public function safeUp()
    {
        if ($this->getDbConnection()->getSchema()->getTable('{{attribute}}')) {
            $this->dropTable('{{attribute_value}}');
            $this->dropTable('{{attribute}}');
        }
    }

    public function safeDown()
    {
        echo "m181022_112914_remove_modules_table does not support migration down.\n";
        return false;
    }
}
