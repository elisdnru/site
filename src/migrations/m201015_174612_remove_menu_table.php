<?php

use yii\db\Migration;

class m201015_174612_remove_menu_table extends Migration
{
    public function safeUp()
    {
        if ($this->getDb()->getTableSchema('menu_items')) {
            $this->dropTable('menu_items');
        }
    }

    public function safeDown()
    {
        echo "m201015_174612_remove_menu_table does not support migration down.\n";
        return false;
    }
}
