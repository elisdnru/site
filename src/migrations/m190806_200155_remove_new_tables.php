<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use yii\db\Migration;

class m190806_200155_remove_new_tables extends Migration
{
    public function safeUp()
    {
        if ($this->getDb()->getTableSchema('{{new}}')) {
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
