<?php

use app\extensions\migrate\EDbMigration;

class m191007_104255_remove_new_gallery_table extends EDbMigration
{
    public function safeUp()
    {
        if ($this->getDbConnection()->getSchema()->getTable('{{new_gallery}}')) {
            $this->dropTable('{{new_gallery}}');
        }
    }

    public function safeDown()
    {
        echo "m191007_200155_remove_new_gallery_table does not support migration down.\n";
        return false;
    }
}