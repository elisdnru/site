<?php
// phpcs:disable
// PSR1.Classes.ClassDeclaration.MissingNamespace

use yii\db\Migration;

class m181022_111111_remove_config extends Migration
{
    public function safeUp()
    {
        if ($this->getDb()->getTableSchema('{{config}}')) {
            $this->dropTable('{{config}}');
        }
    }

    public function safeDown()
    {
        echo "m181022_111111_remove_config does not support migration down.\n";
        return false;
    }
}
