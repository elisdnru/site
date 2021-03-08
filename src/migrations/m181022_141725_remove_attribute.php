<?php

use yii\db\Migration;

class m181022_141725_remove_attribute extends Migration
{
    public function safeUp(): bool
    {
        if ($this->getDb()->getTableSchema('{{attribute}}')) {
            $this->dropTable('{{attribute_value}}');
            $this->dropTable('{{attribute}}');
        }
        return true;
    }

    public function safeDown(): bool
    {
        echo "m181022_112914_remove_modules_table does not support migration down.\n";
        return false;
    }
}
