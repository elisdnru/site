<?php

use yii\db\Migration;

class m200820_225703_remove_contacts_table extends Migration
{
    public function safeUp()
    {
        if ($this->getDb()->getTableSchema('contacts')) {
            $this->dropTable('contacts');
        }
    }

    public function safeDown()
    {
        echo "m200820_225703_remove_contacts_table does not support migration down.\n";
        return false;
    }
}
